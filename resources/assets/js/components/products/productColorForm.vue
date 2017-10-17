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
                  <label>&nbsp;</label>
                  <button type="submit"
                            v-bind:class="[editing ? 'btn-warning' : 'btn-success', 'btn btn-block']"
                            :disabled="form.errors.any()" v-bind:text="productid">
                            {{ editing ? 'Update' : 'Add' }}
                  </button>
              </div>
          </div>
      </form>
  </div>
</template>



<script>

    import { Form } from '../../api/form.js';

    export default {
        props: ['productid'],

        data(){
          return{
            colors:{},
            form : new Form({
              id: '',
              name: '',
              color_id: '',
              product_id: ''
            }),
            editing: false
          }
        },

        watch: {
            form: {
                handler: function(newValue) {
                    this.form.product_id = this.productid;
                    this.form.errors.clear('product_id');
                },
                deep: true
            }
        },

        created(){
          this.getColors();
          Event.$on('edit-product-color', (productcolor) => {
            this.form.load(productcolor);
            this.editing = true;
          });

          Event.$on('reset-form-color', () => {
            this.form.reset();
            this.editing = false;
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
            let self = this;
            if (this.form.id == '') {
              this.form.post('/admin/productcolors')
                .then(data => {
                  self.refreshList();
                  self.notify('Products management',data.message,'success');
                })
                .catch(errors =>{
                  self.notify('Products management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/productcolors')
                .then(data => {
                  self.refreshList();
                  self.notify('Products management',data.message,'success');
                })
                .catch(errors => {
                  self.notify('Products management',errors.message,'warn');
                });
            }

          },

          refreshList(){
              Event.$emit('refresh-productcolors-list');
          },

          notify(title,message,type){
            this.$notify({
              group: 'colors',
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
