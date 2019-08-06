<template>
    <div class="row ">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="font-exo text.muted display-1 text-center">
                        BOARDS
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="bg-light my-2 p-2">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    debug: sort={{table.sortData.current}}, dir={{table.sortData.dir}}, len {{ filteredData.length}}
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <table class="table">
                        <thead>
                        <tr class="bg-light">
                            <th @click="sort('index')" scope="col" class="text-center" style="width: 5%">#</th>
                            <th scope="col" class="text-center" style="width: 10%">Icon</th>
                            <th @click="sort('title')" scope="col" style="width: 50%">Name</th>
                            <th @click="sort('description')" scope="col" style="width: 35%">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr :key=" 'row-' + index" v-for="(board, index) in filteredData" @click="openBoard(board.id)" class="bg-light">
                                <td scope="row" class="align-middle text-center text-body">{{ board.index }}</td>
                                <td class="align-middle"><img src="/img/theme/boards/board.png" class="board-icon d-block mx-auto" alt=""></td>
                                <td class="align-middle"><strong>{{ board.title }}</strong></td>
                                <td class="align-middle">{{ board.description}}</td>
                            </tr>
                            <tr class="bg-light filler"
                                v-if="table.page.current === table.page.pages && table.page.pages > 1"
                                v-for=" n in (table.page.size - filteredData.length)">
                                <td> - </td>
                                <td> - </td>
                                <td> - </td>
                                <td> - </td>
                            </tr>
                        </tbody>
                    </table>
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
                                v-for=" n in table.page.pages" >
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
        data: function() {
            return {
                cats:[],
                // currentSort:'name',
                // currentSortDir:'asc',
                table : {
                    data : [],
                    search  : '',
                    sortData: {
                        current : 'index',
                        dir     : 'asc'     // true => asc | false => desc
                    },
                    page    : {
                        size    : 10,
                        current : 1,
                        pages   : 0,
                    }
                }
            }
        },
        methods : {
            getBoards(){
                // fetch('https://api.myjson.com/bins/s9lux')
                //     .then(res => res.json())
                //     .then(res => {
                //         this.cats = res;
                //     });
                // return 0;
                axios.get('leankit/boards',{'errorHandle' : true})
                    .then( response => {
                        this.setTableData(response.data.boards);
                    })
                    .catch( error => {
                        console.log(error);
                    });
            },
            openBoard(id){
                this.$router.push('board/'+ id);
            },
            // TABLE
            setTableData(data){
                data.forEach( (obj, index) => {
                    obj.index = index + 1;
                    obj.description  = obj.description ? obj.description : ' - ';
                    this.table.data.push(obj);
                    // setTimeout(() => {
                    //     this.table.data.push(obj);
                    // },(index * 210))
                });
                this.table.page.pages = Math.round(this.table.data.length/this.table.page.size);
            },
            sort(key){
                //if s == current sort, reverse
                if(key === this.table.sortData.current) {
                    this.table.sortData.dir = this.table.sortData.dir==='asc'?'desc':'asc';
                }
                this.table.sortData.current = key;
            },
            nextPage(){
                if((this.table.page.current*this.table.page.size) < this.table.data.length) this.table.page.current++;
            },
            prevPage(){
                if(this.table.page.current > 1) this.table.page.current--;
            },
            goPage(page){
                if(this.table.page.current === page) {return true;}
                this.table.page.current = page;
            }

        },
        computed :{
          filteredData(){
              return this.table.data.sort((a,b) => {
                  let modifier = 1;
                  if(this.table.sortData.dir === 'desc') modifier = -1;
                  if(a[this.table.sortData.current] < b[this.table.sortData.current]) return -1 * modifier;
                  if(a[this.table.sortData.current] > b[this.table.sortData.current]) return 1 * modifier;
                  return 0;
              }).filter((row, index) => {
                  let start = (this.table.page.current -1)*this.table.page.size;
                  let end = this.table.page.current*this.table.page.size;
                  if(index >= start && index < end) return true;
              });
          }
        },
        created() {
            this.getBoards();
        }
    }
</script>

<style lang="scss" scoped>
    table.table{
        border-radius: 1em;

        thead{
            th{
                border-top: 0 solid white;
            }
        }
        tbody{
            tr{

                height: 70px;
                &:not(.filler):hover{
                    cursor: pointer;
                    background-color: rgb(174, 213, 255) !important;
                    box-shadow: 10px 10px 30px -16px rgba(0,0,0,0.75);
                    transform: translateZ(260px) scale(1.1);
                }
                td{
                    //transition: all 100ms 210ms ease-in;
                    .board-icon{
                        width: 50px;
                    }
                }
            }
        }
    }
</style>