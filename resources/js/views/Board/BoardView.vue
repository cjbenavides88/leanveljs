<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{ app.board.title}}</h1>
            </div>
        </div>
        <div class="responsive-table ">
            <div class="table-heading bg-light">
                <div class="table-header p-2">Type</div>
                <div class="table-header p-2">Brand</div>
                <div class="table-header p-2">Title</div>
                <div class="table-header p-2">Card ID</div>
                <div class="table-header p-2">Lane</div>
                <div class="table-header p-2">Total Size</div>
                <div class="table-header p-2">Total Tasks</div>
                <div class="table-header p-2">Assigned</div>
            </div>
            <div class="table-body">
                <div :id="index" class="table-row bg-light" v-for="(card, index) in app.cards" >
                    <div class="table-cell p-2">
                        <div class="d-inline-block" data-toggle="tooltip" :title="card.type.title">
                            <svg class=" rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                                <rect width="100%" height="100%" :fill="card.color"></rect>
                            </svg>
                        </div>
                    </div>
                    <div class="table-cell p-2">{{card.customId.value}}</div>
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
<!--        <div class="row" v-for="card in app.cards">-->
<!--            <div class="col">-->
<!--                <div  class="p-1 d-block bg-light">-->
<!--                    <span>{{card.customId.value}}</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
    export default {
        name: "BoardView",
        props : ['id'],
        data: function() {
            return {
                app: {
                    board  : [],
                    cards  : [],
                }
            }
        },
        methods : {
            getBoards(){
                axios.post('leankit/board',{boardID : this.id},{'errorHandle' : true})
                    .then( response => {
                        this.app.board = response.data.board;
                        this.app.cards = response.data.cards.cards;
                    })
                    .catch( error => {
                        console.log(error);
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
        width: 100%;
        display: table;
        border-collapse: separate;

        .table-caption{
            display: table-caption;
        }

        .table-heading{
            display: table-header-group;
            .table-header{
                display: table-cell;
                text-align: left;
            }
        }

        .table-body{
            display: table-row-group;
            .table-row{
                display: table-row;
                .table-cell{
                    display: table-cell;
                }
            }
        }

        .table-footer{
            display: table-footer-group;
            .table-footer-cell{
                display: table-cell;
            }
        }


    }

    .responsive-table{
        border-spacing:0px 1px;
    }
    .table-row{

    }
</style>