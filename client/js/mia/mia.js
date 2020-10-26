Vue.component('mia-calendar', {
    template: `
    <div class="mia-calendar">
        <div class="date" :class="date_selected === date ? 'selected' : ''" v-for="date in dates" @click="$emit('click', date)">
            <div class="date-header">{{date}}</div>
            <div class="date-content">
                <div class="selected" v-if="date_selected === date">
                    {{duration_selected}}
                </div>
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
        }
    },
    data() {
        return {
            dates: []
        }
    },
    methods: {

        generateDates() {

            for (let i = 0; i < 30; i++) {
                let raw = new Date().setDate(new Date().getDate()+i)

                raw = new Date(raw);

                this.$set(this.dates, i, `${raw.getMonth()+1}/${raw.getDate()}/${raw.getFullYear()}`)
            }

        }

    },
    mounted() {

        this.generateDates();

    }

});

let instance = new Vue({
    el: '#mia',
    data: {
        raw_characters: [],
        characters: [],
        duration_options: {
            'Late': 'Late',
            'Entire': 'Entire'
        },
        character_selected: null,
        duration_selected: 'Select Duration',
        date_selected: null
    },
    methods: {
        setDate(payload) {
            this.date_selected = payload;
        },
        getMains() {
            DynamicSuite.call('baddies-insight', 'roster:mains.read', null, response => {
                this.raw_characters = response.data;

                this.raw_characters.forEach(character => {
                    this.$set(this.characters, character.character_id, character.name);
                })
            });
        }
    },
    computed: {
        disableSubmit() {
            return !(
                this.character_selected !== null &&
                this.date_selected !== null &&
                this.duration_selected !== 'Select Duration'
            )
        }
    },
    watch: {},
    created() {

    },
    mounted() {
        this.getMains();
    }
});