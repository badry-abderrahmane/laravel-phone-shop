
import { Errors } from '../api/errors.js';

export class Form{

      /**
      // Start an  instance of form
      // and store given data
      // @param: data
      **/
      constructor(data) {
        this.originalData = data;
        for (let field in data) {
          this[field] = data[field];
        }
        this.errors = new Errors();
      }

      /**
      // get the form data
      //
      **/
      data(){
        let data = {};
        for (let property in this.originalData) {
          data[property] = this[property];
        }

         return data;
      }

      load(data){
        for (let property in this.originalData) {
          this[property] = data[property];
        }
      }
      /**
      // Reset form elements and clear form errors
      //
      **/
      reset(){
        for (let field in this.originalData) {
          this[field] = '';
        }
        this.errors.clear();
      }

      /**
      // post to url
      // @param: url
      **/
      post(url){
        return this.submit('post',url);
      }

      /**
      // put to url
      // @param: url
      **/
      put(url){
        return this.submit('put',url+'/'+this.id);
      }

      /**
      // Submit the form return a promise
      // @param: requestType
      // @param: url
      **/
      submit(requestType, url){
        return new Promise((resolve,reject) => {
          axios[requestType](url, this.data())
              .then(response => {
                this.onSuccess(response.data);
                resolve(response.data);
              })
              .catch(error => {
                this.onFail(error.response.data.errors);
                reject(error.response.data);
              });
        });

      }

      /**
      // After submiting and on success return data
      // @param: data
      **/
      onSuccess(data){
        this.reset();
      }

      /**
      // After submiting and on fail return errors
      // @param: field
      **/
      onFail(errors){
        this.errors.record(errors)
      }

}
