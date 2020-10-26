let main_roster = new Vue({
    el: '#mains',
    data: {
        options: {
            package: 'baddies-insight',
            list_api_read: 'roster:mains.list.read',
            form_api_read: 'roster:mains.form.read',
            form_api_create: 'roster:mains.form.create',
            form_api_update: 'roster:mains.form.update',
            form_api_delete: 'roster:mains.form.delete',
            form_storable_key: 'character_id',
            list_type: 'table',
            list_table_columns: {
                name: 'Name',
                class_id: {
                    label: 'Class',
                    format(value) {
                        return (main_roster.class_options && Object.keys(main_roster.class_options).length > 0)
                            ? main_roster.class_options[value]
                            : value;
                    }
                },
                specialization_id: {
                    label: 'Specialization',
                    format(value) {
                        return (main_roster.all_specializations && Object.keys(main_roster.all_specializations).length > 0)
                            ? main_roster.all_specializations[value]
                            : value;
                    }
                }
            },
            fields: [
                'wow_class',
                'class_id',
                'specialization_id'
            ],
            views: [
                'form'
            ]
        },
        class_options: null,
        specialization_options: [],
        all_specializations: []
    },
    methods: {
        getClasses() {
            DynamicSuite.call('baddies-insight', 'general:classes.read', {}, response => {
                this.class_options = response.data;
            })
        },
        getSpecializations(class_id) {

            let data = {
                class_id: class_id
            };

            DynamicSuite.call('baddies-insight', 'general:specialization.read', data, response => {
                this.specialization_options = Object.assign(
                    {0: ''},
                    response.data
                )
            })

        },
        getAllSpecializations() {
            DynamicSuite.call('baddies-insight', 'general:specializations.read', {}, response => {
                this.all_specializations = response.data
            })
        }
    },
    watch: {
    },
    mounted() {

        this.getClasses();
        this.getAllSpecializations();

    }
});