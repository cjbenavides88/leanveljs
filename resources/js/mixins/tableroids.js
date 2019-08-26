export const tableroids = {
    data() {
        return {
            table: {
                data        : [],
                filteredLen : 1,
                search      : '',
                sortData: {
                    current : '',
                    dir     : 'asc'
                },
                page: {
                    size    : 25,
                    current : 1,
                    pages   : 0,
                },
                spreadsheet : {
                    fileName: '',
                    active  : true,
                }
            }
            ,
        }
    },
    methods : {
        // TABLE
        setTableData(data) {
            data.forEach((obj, index) => {
                this.table.data.push(obj);
            });
            this.table.page.pages = Math.ceil(this.table.data.length / this.table.page.size);
        },
        sort(key) {
            if (key === this.table.sortData.current) {
                this.table.sortData.dir = this.table.sortData.dir === 'asc' ? 'desc' : 'asc';
            }
            this.table.sortData.current = key;
        },
        activeHeader(event){
            event.target.classList.add('active');

        },
        deactiveHeader(event){
            event.target.classList.remove('active');
        },

        //Pagination Functions
        updatePages() {
            let pages = Math.ceil(this.table.filteredLen / this.table.page.size);
            this.table.page.pages = pages === 0 ? 1 : pages;
            this.table.page.current = 1;
        },
        nextPage() {
            if ((this.table.page.current * this.table.page.size) < this.table.filteredLen) this.table.page.current++;
        },
        prevPage() {
            if (this.table.page.current > 1) this.table.page.current--;
        },
        goPage(page) {
            if (this.table.page.current === page) {
                return true;
            }
            this.table.page.current = page;
        },

        //Object Helper Functions
        getValueByString(obj,str){
            if(str.indexOf('.') === -1) { return obj[str]; }

            str = str.replace(/\[(\w+)\]/g, '.$1'); // convert indexes to properties
            str = str.replace(/^\./, '');           // strip a leading dot
            let props = str.split('.');
            for (let i = 0, n = props.length; i < n; ++i) {
                let k = props[i];
                if (k in obj) {
                    obj = obj[k];
                } else {
                    return;
                }
            }
            return obj;
        },
        fetchFromObject(obj, prop) {

            if(typeof obj === 'undefined') {
                return false;
            }

            let _index = prop.indexOf('.');
            if(_index > -1) {
                return this.fetchFromObject(obj[prop.substring(0, _index)], prop.substr(_index + 1));
            }

            return obj[prop];
        }

    },
    computed : {
        filteredData() {

            this.table.filteredLen = 0;
            return this.table.data.filter((result) => {   // Search Quick Filter
                let s = (JSON.stringify(result).toLowerCase().indexOf(this.table.search.toLowerCase()) !== -1);
                if (s) this.table.filteredLen++;
                return s;
            }).sort((a, b) => { // Sort
                let modifier = 1;
                if (this.table.sortData.dir === 'desc') modifier = -1;
                if (this.getValueByString(a, this.table.sortData.current) < this.getValueByString(b, this.table.sortData.current)) return -1 * modifier;
                if (this.getValueByString(a, this.table.sortData.current) > this.getValueByString(b, this.table.sortData.current)) return 1 * modifier;
                return 0;
            }).filter((row, index) => { // Pagination
                let start = (this.table.page.current - 1) * this.table.page.size;
                let end = this.table.page.current * this.table.page.size;
                if (index >= start && index < end) return true;
            });
        },
    }
};