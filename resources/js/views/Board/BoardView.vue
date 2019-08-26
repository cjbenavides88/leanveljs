<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{ app.board.title}}</h1>
            </div>
        </div>
        <div class="bg-light d-flex justify-content-end mb-3 p-2">

            <div class="mr-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="page-size"><i class="fas fa-list-ol"></i></label>
                    </div>
                    <select v-model="table.page.size" class="custom-select" id="page-size" @change="updatePages">
                        <option :value="table.data.length">All</option>
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
            <div class="mr-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-light">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <label for="search" class="d-none">Search</label>
                    <input id="search" autocomplete="off" v-model="table.search" type="text"
                           class="form-control" placeholder="Quick Search" @keyup="updatePages">
                </div>
            </div>
            <div class="">
                <div class="input-group">
                    <transition name="extend">
                        <input v-if="table.spreadsheet.active" id="export" autocomplete="off" v-model="table.spreadsheet.fileName" type="text"
                               class="form-control" placeholder="Export to Excel">
                    </transition>
                    <div class="input-group-append" @click="exportToXLSX">
                        <span class="input-group-text bg-success text-light">
                            <i class="fas fa-save"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-wrapper">
            <div class="responsive-table border-spacing-1 mb-3 ">
                <div class="table-heading bg-light" :class="table.sortData.dir">
                    <div class="table-header sortable" tabindex="0" @click="sort('type.title')" @focusin="activeHeader" @focusout="deactiveHeader">Type</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('customId.value')" @focusin="activeHeader" @focusout="deactiveHeader">Brand</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('title')" @focusin="activeHeader" @focusout="deactiveHeader">Title</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('id')" @focusin="activeHeader" @focusout="deactiveHeader" >Card ID</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('lane.title')" @focusin="activeHeader" @focusout="deactiveHeader">Lane</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('taskBoardStats.totalSize')" @focusin="activeHeader" @focusout="deactiveHeader">Total Size</div>
                    <div class="table-header sortable" tabindex="0" @click="sort('taskBoardStats.totalCount')" @focusin="activeHeader" @focusout="deactiveHeader">Total Tasks</div>
                    <div class="table-header" >Assigned</div>
                </div>
                <div class="table-body">
                    <div :id="index" class="table-row bg-light" v-for="(card, index) in filteredData" >
                        <div class="table-cell p-2">
                            <div class="d-inline-block" data-toggle="tooltip" :title="card.type.title">
                                <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                                    <rect width="100%" height="100%" :fill="card.color"></rect>
                                </svg>
                            </div>
                        </div>
                        <div class="table-cell">{{card.customId.value}}</div>
                        <div class="table-cell p-2">{{card.title}}</div>
                        <div class="table-cell p-2">{{card.id}}</div>
                        <div class="table-cell p-2">{{card.lane.title}}</div>
                        <div class="table-cell p-2 text-center">
                            <div  v-if="card.taskBoardStats">
                                <div>{{ card.taskBoardStats.completedSize }} / {{ card.taskBoardStats.totalSize }}</div>
                                <div class="progress" style="height: 5px;">
                                    <div  class="progress-bar" role="progressbar" :style="{ width : Math.round((card.taskBoardStats.completedSize/card.taskBoardStats.totalSize)*100) + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div v-else> - </div>
                        </div>
                        <div class="table-cell p-2 text-center">
                            <div  v-if="card.taskBoardStats">
                                <div>{{ card.taskBoardStats.completedCount }} / {{ card.taskBoardStats.totalCount }}</div>
                                <div class="progress" style="height: 5px;">
                                    <div  class="progress-bar" role="progressbar" :style="{ width : Math.round((card.taskBoardStats.completedCount/card.taskBoardStats.totalCount)*100) + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div v-else> - </div>
                        </div>
                        <div class="table-cell p-2">
                            <div class="assigned-users" v-if="card.assignedUsers">
                                <div class="d-inline-block mx-1" v-for=" user in card.assignedUsers">
                                    <img class="rounded-lg" :src="user.avatar" :alt="user.fullName" data-toggle="tooltip" :title="user.fullName">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {tableroids} from "../../mixins/tableroids";
    import XLSX from 'xlsx';
    export default {
        name: "BoardView",
        props : ['id'],
        mixins : [tableroids],
        data: function() {
            return {
                app: {
                    board  : [],
                },
            }
        },
        methods : {
            getBoards(){
                axios.post('leankit/board',{boardID : this.id},{'errorHandle' : true})
                    .then( response => {
                        this.setTableData(response.data.cards.cards);
                        this.app.board = response.data.board;
                    })
                    .catch( error => {
                        console.log(error);
                    });
            },
            exportToXLSX(){
                let tableData = this.filteredData;


                let wb = XLSX.utils.book_new();
                wb.Props = {
                    Title   :  'Cards Report',
                    Subject  :  'Cards Report',
                    Author  :  'Yo',
                    CreatedDate :  new Date(),
                };

                wb.SheetNames.push("Test Sheet");
                let ws_data = [
                    ['Type' , 'Brand', 'Title', 'Lane', 'Size', 'Priority', 'Planned Start', 'Planned Finished', 'Actual Start', 'Created On', 'Updated On', 'Moved On', 'URL'] // HEADERS
                ];

                for(let i = 0; i < tableData.length; i++){
                    console.log(tableData[i]);

                    let tmbArray = [
                        tableData[i].type.title,    // 'Type'
                        tableData[i].customId.value,// 'Brand'
                        tableData[i].title,         // 'Title'
                        tableData[i].lane.title,    // 'Lane'
                        tableData[i].taskBoardStats ? tableData[i].taskBoardStats : 0, // 'Size'
                        tableData[i].priority,      // 'Priority'
                        tableData[i].plannedStart,  // 'Planned Start'
                        tableData[i].plannedFinish, // 'Planned Finished'
                        tableData[i].actualFinish,  // 'Actual Start'
                        tableData[i].createdOn,     // 'Created On'
                        tableData[i].updatedOn,     // 'Updated On'
                        tableData[i].movedOn,       // 'Moved On'
                        'https://polaris6365.leankit.com/card/' + tableData[i].id,// 'URL'
                    ];
                    ws_data.push(tmbArray);
                }
                console.log(ws_data);
                wb.Sheets["Test Sheet"] = XLSX.utils.aoa_to_sheet(ws_data);

                let fileName = this.table.spreadsheet.fileName ? this.table.spreadsheet.fileName : 'report';
                fileName = fileName + '.xlsx';

                XLSX.writeFile(wb, fileName);
            }

        },
        created() {
            this.getBoards();
        },
    }
</script>

<style lang="scss" scoped>
    .extend-enter-active {

        animation: extendRight 1s ease-in-out;
    }

    .extend-leave-active{
        animation: extendRight 1s ease-in-out reverse;
    }



    @keyframes extendRight {
        0% {
            width : 0;
            padding: 0.375rem 0;
        }
        100% {
            padding: 0.375rem 0.75rem;
            width : 200px;
        }
    }

</style>