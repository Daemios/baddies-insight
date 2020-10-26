Vue.component('mia-calendar', {
    template: `
    <div class="mia-calendar">
        <div class="date" v-for="date in dates">
            <div class="date-header">{{date}}</div>
            <div class="date-content">
            
            </div>
        </div>
    </div>`,
    props: {

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
        duration_options: [
            'Late',
            'Entire'
        ]
    },
    methods: {
        getMains() {
            DynamicSuite.call('baddies-insight', 'roster:mains.read', null, response => {
                this.raw_characters = response.data;

                this.raw_characters.forEach(character => {
                    this.$set(this.characters, character.character_id, character.name);
                })
            });
        }
    },
    computed: {},
    watch: {},
    created() {

    },
    mounted() {
        this.getMains();
    }
});