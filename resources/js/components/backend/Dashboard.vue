<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 p-5 bg-white border border-#cccccc rounded-lg">
                <h1 class="mt-4 text-center">{{ $t('welcome') }} {{$store.state.currentUser.name}}</h1>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dashboard',
    props: {

    },
    data() {
        return {

        }
    },
    mounted () {
    },
    methods: {

    },
}
</script>