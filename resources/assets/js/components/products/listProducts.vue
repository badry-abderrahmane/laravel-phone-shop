<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <products-form serieid="serieid"></products-form>

      <part-panel>
        <p slot="heading">Products List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block"  @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW PRODUCT
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="productsTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-2">Short Description</th>
                          <th class="col-xs-1">Category</th>
                          <th class="col-xs-1">Serie</th>
                          <th class="col-xs-1">Order</th>
                          <th class="col-xs-1">State</th>
                          <th class="col-xs-1">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="product in products" v-bind:class="[product.state ? 'success' : 'danger']">
                            <td class="col-xs-1">{{ product.id }}</td>
                            <td class="col-xs-2"><span class="label bg-green">{{ product.name }}</span></td>
                            <td class="col-xs-2">{{ product.shortDesc }}</td>
                            <td class="col-xs-1"><span class="label bg-teal">{{ product.category.name }}</span></td>
                            <td class="col-xs-1"><span class="label bg-orange">{{ product.serie.name }}</span></td>
                            <td class="col-xs-1">{{ product.order }}</td>
                            <td class="col-xs-1">
                              <span v-bind:class="[product.state ? 'bg-green' : 'bg-red', 'label']" v-text="product.state ? 'Enabled' : 'Disabled'"></span>
                            </td>
                            <td class="col-xs-1">{{ product.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editProductOptions(product)"  data-toggle="tooltip" title="Show product options"><i class="fa fa-icon fa-bullseye"></i></button>
                                <button class="btn" @click="editProduct(product)" data-toggle="tooltip" title="Edit product"><i class="fa fa-icon fa-edit"></i></button>
                                <button class="btn" @click="enableProduct(product)" v-bind:title="[product.state ? 'Enable product' : 'Disable product']"  data-toggle="tooltip">
                                  <i v-bind:class="[product.state ? 'fa-unlock' : 'fa-lock', 'fa fa-icon']"></i>
                                </button>
                                <button class="btn" @click="destroyProduct(product)" data-toggle="tooltip" title="Delete product"><i class="fa fa-icon fa-trash"></i></button>
                            </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </part-panel>

  </div>


</template>

<script>

    export default {
        props: ['serieid'],
        data() {
            return {
                serie: '',
                products: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (product) => {
                this.getProducts();
            });
            // Event.$on('serie-products-list', (serie) => {
            //     this.serie = serie;
            //     this.getProducts();
            // });
        },

        mounted() {
          this.getProducts();
        },

        methods:{

            getProducts(){
              if (this.serieid == null) {
                console.log(this.serieid);
                axios.get('/admin/products')
                    .then(response => {
                        this.products = response.data;
                    });
              }else{
                console.log(this.serieid);
                axios.get('/admin/series/'+this.serieid)
                    .then(response => {
                      console.log(response.data);
                        this.products = response.data.products;
                    });
              }

            },

            editProduct(product){
              Event.$emit('edit-product', product);
            },

            enableProduct(product){
              product.state = !product.state;
              axios.put('/admin/products/'+product.id, product)
                  .then(data => {
                    this.notify('Products management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Products management',errors.message,'warn');
                  });
            },

            destroyProduct(product) {

                this.$dialog.confirm('Need your confirmation to delete product')
                    .then(function () {
                        axios.delete('/admin/products/' + product.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Products management','Serie well deleted.','warning');
                                },
                                (err) => {
                                    console.log("Err", err);
                                })
                            .catch(function(err){
                                console.error(err); // This will print any error that was thrown in the previous error handler.
                            });
                    })
            },
            editProductOptions(product){
              window.location.href = '/admin/productoptions/'+product.id;
              // Event.$emit('product-options', product);
            },
            resetForm(){
              Event.$emit('reset-form');
            },
            showModal(){
              this.resetForm();
              $('#modal-form').modal('show');
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
            }
        }
    }



</script>
