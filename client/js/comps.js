Vue.component('character', {
    template: `
    <div 
        class="character" 
        :class="cleanClassClasses(character.wow_class)"
        @click.self="$emit('click', character.name)"
    >
        <div class="name"
            @click.self="$emit('click', character.name)"
        >
            {{character.name}}
        </div>
        <aui-button 
            class="delete" 
            v-if="!read_only" 
            @click="$emit('remove')"
        >
            <i class="fas fa-times"></i>
        </aui-button>
    </div>`,
    props: {
        character: {
            type: Object,
            required: true
        },
        read_only: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        cleanClassClasses(wow_class) {
            return 'background-' + wow_class.replace(' ', '').toLowerCase();
        }
    }
});

Vue.component('picker', {
    template: `
    <div class="picker">
        <h1>{{role}}</h1>
        <h2 class="count">{{characters_added.length}}</h2>
        <div class="added">
            <character 
                v-for="character in characters_added"
                :character="character"
                @click="emitReplace(character)"
                @remove="emitRemove(character)"
            ></character>
        </div>
        <div class="add" v-if="characters_unadded.length > 0">
            <aui-button
                @click="emitAdd()"
                class="add-character"
            >
                <i class="fas fa-plus"></i>
            </aui-button>
        </div>
    </div>`,
    props: {
        characters_added: {
            type: Array,
            required: true
        },
        characters_unadded: {
            type: Array,
            required: true
        },
        role: {
            type: String,
            required: true
        }
    },
    methods: {
        getCount() {
            return this.characters_added
        },
        emitReplace(character) {
            this.$emit('replace', {
                character: character,
                role: this.role
            })
        },
        emitAdd(character) {
            this.$emit('add', {
                role: this.role
            })
        },
        emitRemove(character) {
            this.$emit('remove', {
                character: character
            })
        }
    },
    data() {
        return {
            count: null
        }
    },
    mounted() {

    }
});

Vue.component('add-modal', {
    template: `
        <aui-modal
            :title="title"
            :show="show"
            class="add-modal"
            @close="$emit('close')"
        >
            <character
                v-for="character in characters_unadded"
                :character="character"
                :read_only="true"
                @click="emitRosterChange"
            ></character>
        </aui-modal>
    `,
    props: {
        title: {
            type: String,
            required: true
        },
        show: {
            type: Boolean,
            required: true
        },
        characters_unadded: {
            type: Array,
            required: true
        }
    },
    methods: {
        emitRosterChange(character) {
            this.$emit('roster-change', character)
        }
    }
});

Vue.component('raid-date-picker', {
    template: `
    <div class="raid-date-picker">
        <aui-input
            v-model="value"
            label="Raid Week"
            @focus="focus()"
        ></aui-input>
        <aui-modal class="raid-weeks" title="Raid Weeks" :show="show_picker" :closeable="true" @close="show_picker = false">
            <div class="date" v-for="date in dates" @click="chooseDate(date)">
                <span>{{date.start}}</span>
                <span>-</span>
                <span>{{date.end}}</span>
            </div>
        </aui-modal>
    </div>
    `,
    props: {},
    data() {
        return {
            show_picker: false,
            dates: [],
            value: null
        }
    },
    methods: {
        focus() {
            this.show_picker = true;
            this.dates = this.generateMonthOfWeekRanges();
        },
        // Generates a month worth of weeks for selection
        generateMonthOfWeekRanges() {
            let dates = [];

            for (let i = 0; i < 4; i++) {
                let newRange = {};

                // Generate and write a new start date
                let startDate = new Date();
                startDate.setDate(startDate.getDate() + (7 * i) + (2 + 7 - startDate.getDay()) % 7);

                // Format and write the date
                newRange.start = `${startDate.getMonth()+1}/${startDate.getDate()}/${startDate.getFullYear()}`;


                // Generate new end date
                let endDate = new Date();
                endDate.setDate(endDate.getDate() + (7 * i) + (1 + 7 - endDate.getDay()) % 7 );

                // Format and write the date
                newRange.end = `${endDate.getMonth()+1}/${endDate.getDate()}/${endDate.getFullYear()}`;

                dates.push(newRange);


            }

            return dates;
        },
        // Emit events and close menu
        chooseDate(date) {
            this.$emit('date', date.start);
            this.value = date.start;
            this.show_picker = false;
        }
    }
});

let instance = new Vue({
    el: '#comp-builder',
    data: {
        characters: [],
        characters_added: [],
        replace: null,
        instance: null,
        instances: null,
        week: null,
        modal: {
            title: 'Add Character',
            state: false,
            role: null
        },
        boss: {
            selected: null,
            options: []
        }
    },
    methods: {
        // State changers
        replaceModal(payload) {
            this.replace = payload.character;
            this.modal.title = `Replace ${payload.character.name}`;
            this.modal.role = payload.role;
            this.modal.state = true;
        },
        addModal(payload) {
            this.replace = null;
            this.modal.title = 'Add Character';
            this.modal.role = payload.role;
            this.modal.state = true;
        },

        // Data manipulation
        addedCharacters(role) {
            return this.characters.filter(character => {
                return (
                    Object.values(this.characters_added).some(el => el.name === character.name) &&
                    character.role === role
                )
            })
        },
        unAddedCharacters(role) {

            // Filter all characters
            return this.characters.filter(character => {


                // If there are added characters, filter by them and role
                if (this.characters_added.length) {

                    let added_to_list = true;

                    Object.values(this.characters_added).forEach(added => {

                        if (character.name === added.name || character.role !== role) {
                            added_to_list = false
                        }

                    })

                    return added_to_list;
                }

                // Otherwise just filter by role
                else {
                    return character.role === role
                }
            })
        },
        getBossNameRelative(index) {
            return (this.boss.options[parseInt(this.boss.selected) + parseInt(index)])
                ? this.boss.options[parseInt(this.boss.selected) + parseInt(index)]
                : false;
        },
        selectBossAtRelativeIndex(index) {
            this.boss.selected = parseInt(this.boss.selected) + parseInt(index)
        },
        dateChange(payload) {
            this.week = payload;
            this.getRoster()
        },

        // API
        getInstances() {
            DynamicSuite.call('baddies-insight', 'instances:read', null, response => {
                if (response.status === 'OK') {
                    this.instances = response.data;
                    this.instance = Object.keys(response.data)[0]
                    this.getBosses();
                    this.getRoster();
                } else {
                    console.log(response)
                }
            })
        },
        getBosses() {
            let data = {
                instance_id: this.instance
            }

            DynamicSuite.call('baddies-insight', 'bosses:read', data, response => {
                if (response.status === 'OK') {
                    this.boss.options = response.data;
                    this.boss.selected = Object.keys(response.data)[0]
                } else {
                    console.log(response)
                }
            })
        },
        rosterChange(player) {

            let data = {
                week: this.week,
                boss: this.boss.selected,
                player: player
            }

            // Add the replace key/value into the api payload
            if (this.replace) { data.replace = this.replace.name }

            // Send it
            DynamicSuite.call('baddies-insight', 'roster:change', data, response => {
                if (response.status === 'OK') {
                    this.modal.state = false;
                    this.getRoster();
                } else {
                    console.log(response)
                }
            })


        },
        removeCharacter(character) {
            let data = {
                character_id: character.character.character_id,
                boss_id: this.boss.selected,
                week: this.week
            }

            DynamicSuite.call('baddies-insight', 'roster:remove', data, response => {
                if (response.status === 'OK') {
                    this.getRoster();
                } else {
                    console.log(response)
                }
            })
        },
        getMains() {
            DynamicSuite.call('baddies-insight', 'roster:mains.read', null, response => {
                if (response.status === 'OK') {
                    this.characters = response.data
                } else {
                    console.log(response)
                }
            })
        },
        getAlts() {

        },
        getRoster() {
            let data = {
                boss_id: this.boss.selected,
                week: this.week
            }

            DynamicSuite.call('baddies-insight', 'roster:read', data, response => {
                if (response.status === 'OK') {
                    this.characters_added = response.data;
                } else {
                    console.log(reponse)
                }
            })
        },
    },
    watch: {
        boss: {
            handler() {
                if (this.boss.selected) {
                    this.getRoster();
                }
            },
            deep: true
        }
    },
    mounted() {
        this.getInstances();
        this.getMains();
    }
});