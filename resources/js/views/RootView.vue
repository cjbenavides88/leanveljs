<template>
    <login></login>

</template>

<script>
    import LoginForm from '../components/Forms/LoginForm/Form';
    export default {
        name: "RootView",
        components : {
            'login' : LoginForm,
        }
    }
</script>

<style lang="scss" scoped>
</style>

