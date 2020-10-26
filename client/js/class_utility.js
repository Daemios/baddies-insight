let instance = new Vue({
    el: '#class-utility',
    data: {
        options: {
            package: 'baddies-insight',
            list_api_read: 'class_utility:list.read',
            form_api_read: 'class_utility:form.read',
            form_api_create: 'class_utility:form.create',
            form_api_update: 'class_utility:form.update',
            form_api_delete: 'class_utility:form.delete',
            form_storable_key: 'class_utility_id',
            list_type: 'table',
            list_table_columns: {
                id: 'ID',
                class_id: 'Class',
                utility_id: 'Utility',
                cooldown: 'Cooldown'
            },
            fields: [
                'class_id',
                'utility_id',
                'cooldown'
            ],
            views: [
                'form'
            ]
        }
    },
    methods: {},
    computed: {},
    watch: {},
    created() {

    },
    mounted() {

    }
});