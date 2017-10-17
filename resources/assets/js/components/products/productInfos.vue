<template>
  <div>
      <notifications group="productinfos" />
      <div class="row">
        <div class="col-md-3">
          <label for="name">Name</label>
          <p name="name">{{ productinfos.name}}</p>
        </div>
        <div class="col-md-3">
          <label for="category">Category</label>
          <p name="category">{{ productcategory.name}}</p>
        </div>
        <div class="col-md-3">
          <label for="serie">Serie</label>
          <p name="serie">{{ productserie.name}}</p>
        </div>
        <div class="col-md-2">
          <label for="state">State</label>
          <p name="state">{{ productinfos.state}}</p>
        </div>
        <div class="col-md-1">
          <label for="order">Order</label>
          <p name="order">{{ productinfos.order}}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label for="name">Links</label>
          <p name="name">{{ productinfos.links}}</p>
        </div>
        <div class="col-md-3">
          <label for="name">Images</label>
          <p name="name">{{ productinfos.imgs}}</p>
        </div>
        <div class="col-md-3">
          <label for="name">Short description</label>
          <p name="name">{{ productinfos.shortDesc}}</p>
        </div>
        <div class="col-md-3">
          <label for="name">Long description</label>
          <p name="name">{{ productinfos.shortDesc}}</p>
        </div>
      </div>
  </div>
</template>

<script>
  export default{
    props: ['productid'],

    data(){
      return{
        productinfos : {},
        productcategory:{},
        productserie:{}
      }
    },

    created(){
      this.getProductInfos();
    },

    methods:{
      getProductInfos(){
        let optionLabels = {};
        axios.get('/admin/products/'+this.productid)
            .then(response => {
                this.productinfos = response.data;
                this.productcategory = this.productinfos.category;
                this.productserie = this.productinfos.serie;
            });
      },

      notify(title,message,type){
        this.$notify({
          group: 'productinfos',
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
