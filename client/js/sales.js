let instance = new Vue({
    el: '#sales',
    data: {
        options: {
            package: 'baddies-insight',
            list_api_read: 'sale_price:list.read',
            form_api_read: 'sale_price:form.read',
            form_api_create: 'sale_price:form.create',
            form_api_update: 'sale_price:form.update',
            form_api_delete: 'sale_price:form.delete',
            form_storable_key: 'sale_price_id',
            views: {
                form: 'Form'
            },

        },
        form: {
            label: null,
            price: null,
            type: null,
        },
        feedback: {
            label: null,
            price: null,
            type: null,
        },
        calling: false,
        type_options: null
    },
    methods: {
        getTypes() {
            DynamicSuite.call('baddies-insight', 'sale_price:type.read', {}, response => {
                this.type_options = response.data;
            })
        }
    },
    computed: {},
    watch: {},
    created() {

    },
    mounted() {
        this.getTypes();
    }
});