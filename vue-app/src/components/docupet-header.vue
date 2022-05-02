<template>
  <div class="header">
        <div></div>
        <div class="logo">
            <img src="docupet-logo.png"/>
        </div>
        <div class="nav">
            <span @click="help">Help</span>
            <span><a @click="submit">Save and Finish Later</a></span>
        </div>
  </div>
</template>

<script>

export default {
    name: 'docupet-header',
    methods: {
        help(){
            this.$buefy.toast.open({
                message: `Ahhhhh help!`,
                type: 'is-warning',
            })
        },
        submit(){
            console.log('hi')
        }

    }
}
</script>

<style lang="postcss" scoped>

    .header{
        display: flex;
        justify-content: center;
        border-bottom: 5px solid rgba(180, 180, 180, 0.432);
    }

    .logo{
        max-height: 100%;
        padding: .5rem;
        margin-left: auto;
        margin-right: auto;

        & img{
            height: 100%;
            width: 100%;
        }
    }

    .nav{
        padding: 1rem;
        position: absolute;
        right: 1rem;
        top: 8px;

        & span{
            padding-right: 1rem;
        }
    }


    @media only screen and (max-width: 800px) {
        .header{
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            border-bottom: none;
        }

        .nav{
            position: relative;
            display: grid;
            grid-auto-rows: auto;
            gap: 1rem;
            width: 100%;
            right: 0;
        }

    }


</style>
