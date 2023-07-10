<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubCategory</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
</head>
<body class="bg-gray-100">
<div class="flex justify-center items-center min-h-screen"

x-data="{
        formData: {
            name: '',
            parent_id: ''
        },
        isAddingProduct: false,
        products:[],
        categories: [],
        product_id: '{{ $product_id }}',
        fetchCategoryData(id) {
            axios.get(`/product/${id}`)
            .then((response) => {
                this.categories = response.data.categories;
            })
            .catch((error) => {
            console.error('Error fetching categories:', error);
            });
        },
        fetchProductData(id) {
      axios.get(`/products/product/${id}`)
        .then((response) => {
          this.products = response.data.products;
        })
        .catch((error) => {
          console.error('Error fetching products:', error);
        });
        },
        submitCategoryForm() {
            this.formData.parent_id = localStorage.getItem('categoryId') || '';
            axios.post('/', this.formData)
                .then((response) => {
                    console.log('Form submitted:', response.data.message);
                    this.formData.name = '';
                    this.formData.parent_id = '';
                    this.fetchCategoryData(this.product_id);
                    location.reload();
                })
                .catch((error) => {
                    console.error('Error submitting form data:', error);
                });
        },
        submitProductForm() {
            axios.post('/products', this.formData)
                .then((response) => {
                    console.log('Form submitted:', response.data.message);
                    this.formData.name = '';
                    this.formData.parent_id = '';
                    this.fetchProductData(this.product_id);
                    this.isAddingProduct = false;
                    location.reload();
                })
                .catch((error) => {
                    console.error('Error submitting form data:', error);
                });
        },
        deleteCategory: function(id) {
            console.log('Deleting item:', id);
            this.categories = this.categories.filter(category => category.id !== id);
            axios.get(`/delete/${id}`)
            .then(response => {
                console.log('Response:', response.data);
                location.reload();
            })
            .catch(error => {
                console.log('Error:', error);
            });
        },
        deleteProduct: function(id) {
            console.log('Deleting item:', id);
            this.products = this.products.filter(product => product.id !== id);
            axios.get(`/products/delete/${id}`)
            .then(response => {
                console.log('Response:', response.data);
                location.reload();
            })
            .catch(error => {
                console.log('Error:', error);
            })
        },
        toggleProductForm(categoryId) {
            this.formData.parent_id = categoryId;
            this.fetchCategoryData(categoryId);
            this.fetchProductData(categoryId);
            this.isAddingProduct = !this.isAddingProduct;
        },
        initialize() {
            this.fetchCategoryData(this.product_id);
            this.fetchProductData(this.product_id);
        }
    }" x-init="initialize()">
<div class="w-full md:w-2/3 lg:w-1/2 bg-white shadow rounded-lg">
                <div class="p-8">
                <template x-if="isAddingProduct">
            <form x-on:submit.prevent="submitProductForm()">
            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Name:
                            </label>
                            <input id="name" type="text" name="name" placeholder="Enter Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" x-model="formData.name"/>
                        </div>
                        <div class="hidden">
                            <input id="parent_id" type="number" name="parent_id" x-model="formData.parent_id"/>
                        </div>
              <div class="flex justify-center">
                <button
                  type="submit"
                  class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Add Product
                </button>
              </div>
            </form>
          </template>
          <template x-if="!isAddingProduct">
            <form x-on:submit.prevent="submitCategoryForm()">
            <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Name:
                            </label>
                            <input id="name" type="text" name="name" placeholder="Enter Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" x-model="formData.name"/>
                        </div>
                        <div class="hidden">
                            <input id="parent_id" type="number" name="parent_id" x-model="formData.parent_id"/>
                        </div>
              <div class="flex justify-center">
                <button
                  type="submit"
                  class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Add Product Folder
                </button>
              </div>
            </form>
          </template>
                    <div class="mt-8">
                        <ul class="flex flex-wrap">
                        <template x-for="category in categories" :key="category.id">
                                <li x-on:click.prevent="toggleProductForm(category.id)" class="flex items-center mr-4 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-12 w-12 text-purple-500 mr-2"
                                    viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M10 2H4C2.89543 2 2 2.89543 2 4V20C2 21.1046 2.89543 22 4 22H20C21.1046 22 22 21.1046 22 20V8H14C12.8954 8 12 7.10457 12 6V2H10Z"/>
                                    </svg>
                                    <span x-text="category.name" class="text-gray-800"></span>
                                    <button x-on:click.prevent="deleteCategory(category.id)" class="ml-2 text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </li>              
                            </template>
                        </ul>
                        <ul class="flex flex-wrap">
                            <template x-for="product in products" :key="product.id">
                                <li class="flex items-center mr-4 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-500 mr-2"
                                    viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.586 7H17V3.414L20.586 7ZM20 10V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V4C4 2.89543 4.89543 2 6 2H14L20 8V10Z"/>
                                    </svg>
                                    <span x-text="product.name" class="text-gray-800"></span>
                                    <button x-on:click.prevent="deleteProduct(product.id)" class="ml-2 text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>