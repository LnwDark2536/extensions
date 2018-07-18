var app = new Vue({
    el: '#search-user',
    data: {
        message: 'Hello Vue!',
        dataUser: [],
        search: '',
        viewData: [],
        DetailsRegister: [],
        DataShirts: []
    },
    mounted() {
        this.$refs.search.focus();
    },
    created() {
        this.GetData()
    },
    filters: {
        checkSex: function (value) {
            if (value == 1){
                return 'ชาย';
            }else {
                return 'หญิง';
            }


        }
    },
    computed: {
        filterShow() {
            var search_data = this.dataUser;
            searchString = this.search;
            if (!searchString) {
                return search_data;
            }
            searchString = searchString.trim().toLowerCase();
            search_data = search_data.filter(item => {
                if((!searchString || item.firstname.toLowerCase().indexOf(searchString) !== -1 ||
                item.lastname.toLowerCase().indexOf(searchString) !== -1
                || item.phone.toLowerCase().indexOf(searchString) !== -1)

        )
            return item;
        })
            ;
            return search_data;
        }
    },
    methods: {
        check: function (model) {
            if(model.status == 6){
                return 'success';
            }else{
                return '';
            }
        },
        GetData: function () {
            var that = this;
            return jQuery.get('api-get-data', function (data) {
                that.dataUser = data
            });
        },
        View: function (id) {
            var that = this;
            var dataSelect = this.dataUser.filter(item => item.id === id
        );
            //ข้อมุลสมาชิก
            jQuery.get('get-details?id=' + id, function (data) {
                that.DetailsRegister = data
            });
            //รายการเสื้อ
            jQuery.get('get-data-shirts?id=' + id, function (data) {
                that.DataShirts = data
            });
            return this.viewData = dataSelect;
        },
        SaveData: function (model) {
           var con= confirm("ยีนยันการรับของใช่หรือไม่ ?");
           if(con){
               jQuery.get('save-data?id=' + model.id, function (data) {
                   console.log(data)
               });
           }
           console.log(con);
        }
    }
});