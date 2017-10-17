<template>
  <div>
    <notifications group="options" />
      <form v-on:submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
          <div class="row">
            <div class="col-md-4">
                <div v-bind:class="{ 'has-error': form.errors.get('option_id') }">
                    <label>Option</label>
                    <select class="form-control" name="option_id" v-model="form.option_id" @change="form.errors.clear('option_id')">
                          <option v-for="option in options" v-bind:value="option.id"> {{ option.name }}</option>
                    </select>
                    <!-- <input type="text" name="option_id" class="form-control" v-model="form.option_id"/> -->
                    <span class="help-block" v-if="form.errors.has('option_id')" v-text="form.errors.get('option_id')"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div v-bind:class="{ 'has-error': form.errors.get('value') }">
                    <label>Value</label>
                    <input type="text" name="value" class="form-control" v-model="form.value" />
                    <span class="help-block" v-if="form.errors.has('value')" v-text="form.errors.get('value')"></span>
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
            options:{},
            form : new Form({
              id: '',
              value: '',
              option_id: '',
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
          this.getOptions();
          Event.$on('edit-product-option', (productoption) => {
            this.form.load(productoption);
            this.editing = true;
          });

          Event.$on('reset-form-option', () => {
            this.form.reset();
            this.editing = false;
          });
        },

        methods: {
          getOptions(){
            axios.get('/admin/options')
                .then(response => {
                    this.options = response.data;
                });
          },
          onSubmit(){
            let self = this;
            if (this.form.id == '') {
              this.form.post('/admin/productoptions')
                .then(data => {
                  self.refreshList();
                  self.notify('Products management',data.message,'success');
                })
                .catch(errors =>{
                  self.notify('Products management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/productoptions')
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
              Event.$emit('refresh-productoptions-list');
          },

          notify(title,message,type){
            this.$notify({
              group: 'options',
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
