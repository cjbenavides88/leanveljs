<template>
    <div class="container">
        <div class="row ">
            <div class="col">
                <div class="font-exo text.muted display-1 text-center">BOARDS</div>
                <div class="bg-light d-flex justify-content-end mb-3 p-2">
                    <div class="mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="page-size"><i class="fas fa-list-ol"></i></label>
                            </div>
                            <select v-model="table.page.size" class="custom-select" id="page-size" @change="updatePages">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-light" id="basic-addon1"><i
                                        class="fas fa-search"></i></span>
                            </div>
                            <label for="search" class="d-none">Search</label>
                            <input id="search" autocomplete="off" v-model="table.search" type="text"
                                   class="form-control" placeholder="Quick Search" @keyup="updatePages">
                        </div>
                    </div>
                </div>
                <div class="table-wrapper">
                    <div class="responsive-table border-spacing-1 mb-3">
                        <div class="table-heading bg-light">
                            <div class="table-header text-center" style="width: 5%">#</div>
                            <div class="table-header text-center" style="width: 10%">Icon</div>
                            <div class="table-header" style="width: 50%">Name</div>
                            <div class="table-header" style="width: 35%">Description</div>
                        </div>
                        <div class="table-body">
                            <div class="table-row bg-light" :key=" 'row-' + index" v-for="(board, index) in filteredData" @click="openBoard(board.id)">
                                <div class="table-cell align-middle text-center text-body">{{ board.index }}</div>
                                <div class="table-cell align-middle">
                                    <img src="/img/theme/boards/board.png"
                                         class="board-icon d-block mx-auto w-50" alt="">
                                </div>
                                <div class="table-cell align-middle text-body"><strong>{{ board.title }}</strong></div>
                                <div class="table-cell align-middle text-body">{{ board.description}}</div>
                            </div>

                            <div class="table-row bg-light filler"
                                v-for=" n in (table.page.size - filteredData.length)">
                                <div class="table-cell align-middle"> -</div>
                                <div class="table-cell align-middle"> -</div>
                                <div class="table-cell align-middle"> -</div>
                                <div class="table-cell align-middle"> -</div>
                            </div>
                        </div>
                    </div>

                    <nav>
                        <ul class="pagination justify-content-center">
                            <li @click="prevPage"
                                class="page-item"
                                :class="{ 'disabled' : table.page.current === 1}">
                                <div class="page-link user-select-none">Previous</div>
                            </li>
                            <li @click="goPage(n)"
                                class="page-item"
                                :class="{ 'active' : table.page.current === n}"
                                v-for=" n in table.page.pages">
                                <div class="page-link user-select-none">{{ n }}</div>
                            </li>
                            <li @click="nextPage"
                                class="page-item"
                                :class="{ 'disabled' : table.page.current ===  table.page.pages}">
                                <div class="page-link user-select-none">Next</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Boards",
        data: function () {
            return {
                table: {
                    data: [],
                    filteredLen: 1,
                    search: '',
                    sortData: {
                        current: 'index',
                        dir: 'asc'
                    },
                    page: {
                        size: 10,
                        current: 1,
                        pages: 0,
                    }
                }
            }
        },
        methods: {
            getBoards() {
                axios.get('leankit/boards', {'errorHandle': true})
                    .then(response => {
                        this.setTableData(response.data.boards);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            openBoard(id) {
                this.$router.push('board/' + id);
            },
            // TABLE
            setTableData(data) {
                data.forEach((obj, index) => {
                    obj.index = index + 1;
                    obj.description = obj.description ? obj.description : ' - ';
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


        },
        computed: {
            filteredData() {
                this.table.filteredLen = 0;
                return this.table.data.filter((result) => {   // Search Quick Filter
                    let s = (JSON.stringify(result).toLowerCase().indexOf(this.table.search.toLowerCase()) !== -1);
                    if (s) this.table.filteredLen++;
                    return s;
                }).sort((a, b) => { // Sort
                    let modifier = 1;
                    if (this.table.sortData.dir === 'desc') modifier = -1;
                    if (a[this.table.sortData.current] < b[this.table.sortData.current]) return -1 * modifier;
                    if (a[this.table.sortData.current] > b[this.table.sortData.current]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => { // Pagination
                    let start = (this.table.page.current - 1) * this.table.page.size;
                    let end = this.table.page.current * this.table.page.size;
                    if (index >= start && index < end) return true;
                });
            },
        },
        created() {
            this.getBoards();
        }
    }
</script>

<style lang="scss" scoped>
    .responsive-table {
        .table-heading{
            .table-header{
            }
        }
        .table-body{
            .table-row{
                height: 75px;
                border-radius: 40px;
                transition: transform .2s ease-in-out,
                            box-shadow .3s .2s ease-in;

                &:not(.filler):hover {
                    cursor: pointer;
                    background-color: rgb(174, 213, 255) !important;
                    box-shadow: 10px 10px 30px -16px rgba(0, 0, 0, 0.75);
                    transform: translateZ(260px) scale(1.1);
                }
            }
        }
    }
</style>