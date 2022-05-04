<template>
    <div class="form-con">
        <div class="form-box">
            <div class="pawprints">
                <font-awesome-icon icon="paw" class="green"></font-awesome-icon>
                <font-awesome-icon icon="paw" class="green"></font-awesome-icon>
                <font-awesome-icon icon="paw" v-for="index in 5" :key="index"></font-awesome-icon>
            </div>
            <div class="form">
                <span class="big-bold">Tell us about your {{form.selected_pet_type || 'pet'}}</span>

                <div class="form-control">
                    <label>What kind of pet are they?</label>
                    <b-select v-model="form.selected_pet_type">
                        <option v-for="pet of pet_types" :key="pet">{{pet}}</option>
                    </b-select>
                </div>

                <div class="form-control">
                    <label>What is your {{form.selected_pet_type || "pet"}}'s name?</label>
                    <b-input v-model="form.pet_name"></b-input>
                </div>

                <div class="form-control" v-if="form.selected_pet_type">
                    <label>What breed are they?</label>
                    <b-select
                        v-model="form.breed"
                        icon-right="magnify">
                        <option v-for="breed of breed_list" :key="breed">{{breed}}</option>
                    </b-select>
                </div>
                <div class="form-control no-breed" v-if="form.breed == 'Can\'t find your breed?'">
                    <label>Choose One</label>
                    <b-radio
                        v-model="form.breed_option" native-value="unknown">I don't know
                    </b-radio>
                    <b-radio
                        v-model="form.breed_option" native-value="mix">It's a mix
                    </b-radio>
                </div>
                <div class="form-control">
                    <label>What gender are they?</label>
                    <b-field>
                    <b-radio-button
                        v-model="form.gender" native-value="f">Female
                    </b-radio-button>
                    <b-radio-button
                        v-model="form.gender" native-value="m">Male
                    </b-radio-button>
                    </b-field>
                </div>
                <div class="form-control">
                    <div class="submit">
                        <b-button type="is-primary" :disabled="disabled" @click="submit">Continue</b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'docupet-form',
    data(){
        return {
            search_term: '',

            pet_types: ["Cat", "Dog"],
            cat_breeds: ['Domestic Shorthair', 'Calico', 'Tabby'],
            dog_breeds: ['Boxer', 'Pit bull', 'Golden'],

            form:{
                breed: '',
                pet_name: '',
                selected_pet_type: '',
                breed_option: '',
                gender: '',
            }
        }
    },
    computed: {
        breed_list(){
            let arr = []
            if(this.form.selected_pet_type == "Cat") arr.push(...this.cat_breeds)
            if(this.form.selected_pet_type == "Dog") arr.push(...this.dog_breeds)
            arr.push("Can't find your breed?")
            return arr
        },
        disabled(){
            if(this.form.breed == "Can't find your breed?" && !this.form.breed_option){
                return true
            }
            if(!this.form.pet_name){ 
                return true
            }
            if(!this.form.breed){ 
                return true
            }
            if(!this.form.selected_pet_type){ 
                return true
            }
            if(!this.form.gender){ 
                return true
            }
            return false
        }
    },
    methods: {
        submit(){
            this.$http.post('/', this.form)
        }
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

    .form-control{
        padding-bottom: 1rem;
    }


    .form{
        text-align: left;
        padding: 1rem 4rem;
        display: grid;
        grid-auto-flow: row;
    }

    .no-breed{
        padding-left: 3rem;
        display: grid;
        grid-auto-flow: row;
        gap: 1rem;
        
    }

    .big-bold{
        font-size: 1.4rem;
        padding: 1rem 0rem;
        font-weight: 500;
        color: rgb(0, 0, 177)
    }

    .submit{
        display: flex;
        justify-content: center;
    }

    .pawprints{
        padding: 1rem 2rem;
        display: grid;
        grid-auto-flow: column;
        align-items: center;
        justify-items: center;

        & svg{
            transform: rotate(90deg);
            height: 2rem;
            width: 2rem;
            color: gray;
        }

        & .green{
            color: rgb(0, 180, 0);
        }

        & :nth-child(even) {
            margin-top: 1.5rem;
        }
    }

    @media only screen and (max-width: 900px) {
        .form-con{
            width: 80%;
        }

        .pawprints{
            display: none;
        }
    }

</style>
