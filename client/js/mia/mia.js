Vue.component('mia-calendar', {
    template: `
    <div class="mia-calendar">
        <aui-input type="date" label="" :disabled="true" v-if="false"></aui-input>
        <div class="date" :class="date_selected === date ? 'selected' : ''" v-for="data, date in dates" @click="$emit('click', date)">
            <div class="date-header">{{date}}</div>
            <div class="mias" v-if="data.mias.length > 0">
                {{data.mias.length}} <span>MIA</span>
            </div>
        </div>
    </div>`,
    props: {
        date_selected: {
            type: String|null,
            required: true
        },
        duration_selected: {
            type: String|null
        },
        dates: {
            type: Array|null,
            required: true
        },
        character: null
    },
    data() {
        return {}
    },
    methods: {},
    mounted() {

    }

});

let instance = new Vue({
    el: '#mia',
    data: {
        posted: false,
        raw_characters: [],
        characters: [],
        duration_options: {
            'Late': 'Late',
            'Entire': 'Entire'
        },
        duration_selected: 'Select Duration',
        character_selected: null,
        dates: null,
        date_selected: null,
        note: null,
        modal: false
    },
    methods: {
        openModal(payload) {
            this.date_selected = payload;
            this.modal = true;
        },
        clear() {
            this.modal = false;
            this.date_selected = null;
            this.posted = false;
        },
        classColorClass(wow_class) {
            return 'background-' + wow_class.replace(' ', '-').toLowerCase();
        },


        // API Stuff
        getMains() {
            DynamicSuite.call('baddies-insight', 'roster:mains.read', null, response => {
                this.raw_characters = response.data;

                this.raw_characters.forEach(character => {
                    this.$set(this.characters, character.character_id, character.name);
                })
            });
        },
        saveMia() {
            const data = {
                character: this.character_selected,
                date:      this.date_selected,
                duration:  this.duration_selected,
                note:      this.note
            };

            DynamicSuite.call('baddies-insight', 'mia:create', data, response => {
                switch (response.status) {
                    case 'OK':
                        this.posted = true;
                        this.getCalendarData();
                        console.log(response)
                        break;
                }
            });
        },
        getCalendarData() {
            const data = {
                unix: new Date().getTime() / 1000
            }

            DynamicSuite.call('baddies-insight', 'mia:read', data, response => {
                this.dates = response.data;
            })
        }
    },
    computed: {
        disableSubmit() {
            return !(
                this.character_selected !== null &&
                this.duration_selected !== 'Select Duration' &&
                this.note !== null
            )
        },
        miaForDate() {
            let mias = [];

            if (this.date_selected && this.dates[this.date_selected].mias) {
                this.dates[this.date_selected].mias.forEach(mia => {
                    mias.push(mia)
                })
            }

            return mias;
        }
    },
    watch: {},
    created() {

    },
    mounted() {
        this.getMains();
        this.getCalendarData();
    }
});