<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            formData: {
                name: '',
                image: '',
                otherImage: [],
                price: '',
                public: '',
                desc: '',
            },
            imageSize: 0,
        };
    },
    methods: {
        submitData() {
            const { formData } = this;
            if (this.imageSize > 3145728) return Swal.fire('圖片檔案過大');
            // 驗證
            router.visit(route('product.store'), {
                method: 'post',
                data: formData,
                preserveState: true,
                onSuccess: ({ props }) => {
                    // console.log(props);
                    if (props.flash.message.rt_code === 1) {
                        Swal.fire({
                            title: '新增成功',
                            showDenyButton: true,
                            confirmButtonText: '回列表',
                            denyButtonText: '取消',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                router.get(route('product.list'));
                            }
                        });
                    }
                },
            });
        },

        uploadImage(event) {
            const reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);
            reader.onload = () => {
                console.log(reader.result);
                this.formData.image = reader.result;
                this.imageSize += event.target.files[0].size;
            };
        },
        uploadOtherImage(event) {
            const reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);
            reader.onload = () => {
                this.formData.otherImage.push({
                    id: Math.max(0, ...this.formData.otherImage.map(item => item.id)) + 1,
                    img_path: reader.result,
                    // sort: this.formData.otherImage.length + 1,
                    size: event.target.files[0].size,
                });
                this.imageSize += event.target.files[0].size;
            };
        },
        removeImage(id) {
            this.imageSize -= this.formData.otherImage.find((item) => item.id === id).size;
            this.formData.otherImage = this.formData.otherImage.filter((item) => item.id !== id);
        },
    },
};
</script>

<template>
  <Head title="Product" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 新增產品</h2>
      </div>
    </template>
    <section id="product-create" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white mt-[30px] rounded-[6px]">
      <form @submit.prevent="submitData()">
        <label>商品名稱:
          <input v-model="formData.name" name="name" type="text" required>
        </label>
        <label>商品照片:
          <div class="relative inline-block">
            <div v-if="!formData.image" class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
              +
            </div>
            <img v-else :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="">
            <input id="image" class="absolute top-1/2 left-1/2 translate-y-[10px] opacity-0" name="image" type="file" required @change="(event) => uploadImage(event)">
          </div>
        </label>
        其他照片:
        <div class="flex flex-wrap gap-[30px]">
          <div v-for="item in formData.otherImage" :key="item.id" class="relative">
            <img :src="item.img_path" class="w-[200px] aspect-[4/3] object-cover" alt="">
            <button type="button" class="rounded-full w-[20px] h-[20px] bg-[red] text-[white] flex justify-center items-center absolute top-0 right-0 translate-x-1/2 -translate-y-1/2" @click="removeImage(item.id)">X</button>
          </div>
          <label class="border w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
            +
            <input type="file" class="hidden" @change="(event) => uploadOtherImage(event)">
          </label>
        </div>
        <label>商品價格:
          <input v-model="formData.price" name="price" type="number" min="0" required>
        </label>
        <div class="flex items-center gap-[10px]">公開/非公開:
          <label>
            <input v-model="formData.public" name="public" type="radio" value="1" required>公開
          </label>
          <label>
            <input v-model="formData.public" name="public" type="radio" value="2">不公開
          </label>
        </div>
        <label>商品描述:
          <input v-model="formData.desc" name="desc" type="text">
        </label>
        <div class="flex justify-center items-center gap-[45px]">
          <Link :href="route('product.list')">
            <button type="button" class="btn">取消新增</button>
          </Link>
          <button type="submit" class="btn">確認新增</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
    form {
        @apply flex flex-col gap-[10px];
    }

    .btn {
        @apply border border-[#3b82f680] bg-[#3b82f680] font-bold px-[15px] py-[10px] rounded-[5px];
    }
}
</style>
