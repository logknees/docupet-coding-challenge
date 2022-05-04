<template>
    <div class="page">
        <docupet-form></docupet-form>
    </div>
</template>

<script>

export default {
    name: 'docupet-homepage',
    components: {

    }
}
</script>

<style lang="postcss" scoped>
    .page{
        display:flex;
        flex-direction: column;
        align-items: center;
        background-color: rgb(190, 190, 190);
    }

    @media only screen and (max-width: 900px) {
        .page{
            background-color: rgb(255, 255, 255);
        }
    }

</style>
