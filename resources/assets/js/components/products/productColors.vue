<template>
  <div>
      <notifications group="productcolors" />
      <div class="nav-tabs-custom">
            <product-color-form :productid="productid"></product-color-form><br><br>
            <table class="table">
              <tbody>
                <tr v-for="productColor in productColors">
                  <td><b>{{ productColor.name }}</b></td>
                  <td><font v-bind:background-color="productColor.color.code">{{ productColor.color.name }}</font></td>
                  <td>
                    <div v-bind:style="{ width: '30px', height: '30px', backgroundColor: productColor.color.code}"></div>
                  </td>
                  <td>
                    <button class="btn" @click="editProductColor(productColor)"><i class="fa fa-icon fa-edit"></i></button>
                    <button class="btn" @click="destroyProductColor(productColor)"><i class="fa fa-icon fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
      </div>
  </div>
</template>

<script>
  export default{
    props: ['productid'],


    data(){
      return{
        productColors : {}
      }
    },
    created(){
      this.getProductColors();
      Event.$on('refresh-productcolors-list', () => {
        this.getProductColors();
      });
    },

    methods:{
      getProductColors(){
        axios.get('/admin/productcolors/'+this.productid+'/edit')
            .then(response => {
                this.productColors = response.data;
            });
      },

      destroyProductColor(productColor) {
          let self = this;
          this.$dialog.confirm('Need your confirmation to delete color')
              .then(function () {
                  axios.delete('/admin/productcolors/' + productColor.id)
                      .then(response => {
                              self.getProductColors();
                              self.notify('Products management','Product color well deleted.','warn');
                          },
                          (err) => {
                              console.log("Err", err);
                          })
                      .catch(function(err){
                          self.notify('Products management',err,'error');
                      });
              })
      },

      editProductColor(productColor){
        Event.$emit('edit-product-color', productColor);
      },

      notify(title,message,type){
        this.$notify({
          group: 'productcolors',
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
