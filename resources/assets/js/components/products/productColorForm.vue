<template>
  <div>
    <notifications group="colors" />
      <form v-on:submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
          <div class="row">
              <div class="col-md-4">
                  <div v-bind:class="{ 'has-error': form.errors.get('name') }">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" v-model="form.name" />
                      <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                  </div>
              </div>
              <div class="col-md-4">
                  <div v-bind:class="{ 'has-error': form.errors.get('color_id') }">
                      <label>Color</label>
                      <select class="form-control" name="color_id" v-model="form.color_id" @change="form.errors.clear('color_id')">
                            <option v-for="color in colors" v-bind:value="color.id"> {{ color.name }}</option>
                      </select>
                      <!-- <input type="text" name="color_id" class="form-control" v-model="form.color_id"/> -->
                      <span class="help-block" v-if="form.errors.has('color_id')" v-text="form.errors.get('color_id')"></span>
                  </div>
              </div>
              <div class="col-md-4">
                  <label>.</label>
                  <button type="submit" class="btn btn-success btn-block" :disabled="form.errors.any()">ADD NEW</button>
              </div>
          </div>
      </form>
  </div>
</template>



<script>

    import { Form } from '../../api/form.js';

    export default {
        props: ['id'],

        data(){
          return{
            colors:{},
            form : new Form({
              id: '',
              name: '',
              color_id: '',
              product_id: ''
            })
          }
        },

        watch: {
            form: {
                handler: function(newValue) {
                    this.form.product_id = this.id;
                },
                deep: true
            }
        },

        created(){
          this.getColors();
          Event.$on('edit-color', (color) => {
            this.form.load(color);
          });

          Event.$on('reset-form-color', () => {
            this.form.reset();
          });
        },

        methods: {
          getColors(){
            axios.get('/admin/colors')
                .then(response => {
                    this.colors = response.data;
                });
          },
          onSubmit(){
            if (this.form.id == '') {
              let self = this;
              this.form.post('/admin/productcolors')
                .then(data => {
                  this.refreshList();
                  this.notify('Products management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Products management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/productcolors')
                .then(data => {
                  this.refreshList();
                  this.notify('Products management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Products management',errors.message,'warn');
                });
            }

          },

          refreshList(){
              Event.$emit('refresh-productcolors-list');
              this.quitModal();
          },

          notify(title,message,type){
            this.$notify({
              group: 'foo',
              type: type,
              title: title,
              text: message,
              duration: 10000,
              speed: 1000
            });
          },
        }
    }



</script>
