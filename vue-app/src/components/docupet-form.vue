<template>
    <div class="form-con">
        <div class="form-box">
            <div class="pawprints">
                <font-awesome-icon icon="paw" class="green"></font-awesome-icon>
                <font-awesome-icon icon="paw" class="green offset"></font-awesome-icon>
                
            </div>
            <div class="form">
                <h2>Tell us about your dog</h2>

            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'docupet-form',
    components: {
    
    }
}
</script>

<style lang="postcss" scoped>
    .form-con{
        min-height: 100%;
        height: auto;
        display: flex;
        flex: 1 0 auto;
        align-self: center;
        width: 30%;
    }

    .form-box{
        min-height: 90%;
        height: auto;
        border-radius: 10px;
        display: flex;
        flex: 1 0 auto;
        flex-direction: column;
        width: 100%;
        background-color: white;
        justify-self: center;
        align-self: center;
    }

    .form{
        text-align: left;
        padding: 3rem;
    }

    .pawprints{
        padding: 1rem 3rem;
        display: grid;
        grid-auto-flow: column;

        & svg{
            transform: rotate(90deg);
            height: 2rem;
            width: 2rem;
        }

        & .offset{
            margin-top: 1rem;
        }
  }

</style>
