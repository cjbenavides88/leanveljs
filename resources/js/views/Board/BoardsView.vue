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
                <div class="col-lg-2 py-2" v-for="(board, index) in app.boards">
                    <div :id="board.id" class="card h-100">
                        <div class="card-body h-100 ">
                            <h5 class="card-title">{{ board.title }}</h5>
                            <p class="card-text ">{{ board.description }}</p>
                            <p class="text-right">
                                <a href="#" class="btn btn-primary">See Board</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BoardsView",
        data: function() {
            return {
                app: {
                    boards  : [],
                }
            }
        },
        methods : {
            getBoards(){
                axios.get('leankit/boards',{'errorHandle' : true})
                    .then( response => {
                        this.app.boards = response.data.boards;
                    })
                    .catch( error => {
                        console.log(error);
                    });
            }
        },
        created() {
            this.getBoards();
        }
    }
</script>

<style scoped>

</style>