<template>
    <div>
        <h1>BOARD {{id}}</h1>
        <div v-for="card in app.cards" class="p-4 my-4 d-block bg-light rounded">
            <div class="h4">{{card.title}}</div>
            <div class="text-muted"><span v-html="card.description"></span></div>
        </div>
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

<style scoped>

</style>