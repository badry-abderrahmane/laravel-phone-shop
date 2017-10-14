<template>
  <div>
    <notifications group="product-options" />
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Product Informations</h3>
              </div>
              <div class="box-body">
                <div class="col-md-3">
                    <label>Name</label>
                    <h4><span class="label bg-green">{{ product.name }}</span></h4>
                </div>
                <div class="col-md-3">
                    <label>Category</label>
                    <h4><span class="label bg-green">{{ product.category.name }}</span></h4>
                </div>
                <div class="col-md-3">
                    <label>Serie</label>
                    <h4><span class="label bg-green">{{ product.serie.name }}</span></h4>
                </div>
                <div class="col-md-3">
                    <label>State</label>
                    <h4><span class="label bg-green">{{ product.state }}</span></h4>
                </div>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-warning">
              <div class="box-header">
                <h3 class="box-title">Product Colors</h3>
              </div>
              <div class="box-body">
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('name') }">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" />
                        <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>
                    <div v-bind:class="{ 'has-error': form.errors.get('name') }">
                        <label>Images</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" />
                        <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>
                    <div v-bind:class="{ 'has-error': form.errors.get('name') }">
                        <label>Color</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" />
                        <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>
                    <br><button type="submit" class="btn btn-warning btn-block" :disabled="form.errors.any()">Add</button>
                  </div>
                  <div class="col-md-6">
                      <div>
                          <label>Colors in stock</label>
                          <table>
                            <tbody>
                              <!-- <tr v-for="productcolor in product.productcolors">
                                <td>{{ productcolor.color.name }}</td>
                              </tr> -->
                            </tbody>
                          </table>
                      </div>

                    </div>
              </div>
              <!-- /.box-body -->
          </div>
        </div>
      </div>

        <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Product Options</h3>
            </div>
            <div class="box-body">

            </div>
            <!-- /.box-body -->
        </div>
      <form v-on:submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
          <div class="row"><br>
              <div class="col-md-4"></div>
              <div class="col-md-4">
                  <button type="submit" class="btn btn-success btn-block" :disabled="form.errors.any()">Save</button>
              </div>
          </div>
      </form>
  </div>
</template>



<script>

    import { Form } from '../../api/form.js';

    export default {
        data(){
          return{
            form : new Form({
              id: '',
              name: '',
            }),
            product:[]
          }
        },

        created(){
          Event.$on('product-options', (product) => {
            this.product = product;
            $('#modal-product-options').modal('show');
          });

          Event.$on('reset-form', () => {
            this.form.reset();
          });
        },

        methods: {
          quitModal(){
            $('#modal-product-options').modal('hide');
            $('.modal-backdrop').attr('class','');
          }
        }
    }



</script>
