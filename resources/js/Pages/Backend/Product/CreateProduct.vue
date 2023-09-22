<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';
import { Head, router } from '@inertiajs/vue3';

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
        price: '',
        publice: '',
        desc: '',
      },
      imageSize: 
    };
  },
  methods: {
    SubmitData() {
      const { formData } = this;
      //  驗證
      router.visit(route('product.store'), {
        method: 'post', data: formData, preserveState: true,
        onSuccess: ({ props }) => {
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '新增成功',
              showDenyButton: true,
              confirmButtonText: '回列表',
              denyButtonText: '取消',
            }).then((result) => {

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
        formData.image = reader.result;
      };
      reader.onerror = function (error) {
        console.log('Error: ', error);
      };
    },
  },
};
</script>

<template>
  <Head title="product-create" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product 新增商品</h2>
      </div>
    </template>
    <section id="product-create" class="px-[15px] py-[10px]">
      <form @submit.prevent="SubmitData()">
        <label>
          商品名稱
          <input v-model="formData.name" name="name" type="text" required>
        </label>
        <input v-model="formData.image" type="hidden" required>
        <label>
          商品照片
          <div class=""></div>
          <div v-if="!formData.image" for="image" class="border border-dashed border-[gray] w-[200px] aspect-[4/3] flex justify-center items-center text-[48px] cursor-pointer">
            +
          </div>
          <img v-else :src="formData.image" class="w-[200px] aspect-[4/3] object-cover" alt="">
          <input id="image" class="hidden" name="image" type="file" required @change="(event) => uploadImage(event)">
        </label>
        <label>
          商品價格
          <input v-model="formData.price" neme="price" type="number" min="0" required>
        </label>
        <div class="flex items-center gap-[10px]">
          公開/非公開:
          <label>
            <input v-model="formData.publice" type="radio" value="1" required>
            公開
          </label>
          <label>
            <input v-model="formData.publice" type="radio" value="2">
            非公開
          </label>
        </div>
        <label>
          商品描述
          <input v-model="formData.desc" type="text" name="desc">
        </label>>
        <div class="flex justify-center items-center gap-[45px]">
          <Link :href="route('product.list')">
            <button class="btn" type="button">取消新增</button>
          </Link>
          <button class="btn" type="submit">確認新增</button>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
#product-create {
    form {
        @apply flex flex-col gap-[10px];

        .btn {
            @apply border border-[#3b82f680] bg-[#3b82f680] font-bold px-[15px] py-[10px] rounded-[5px];
        }
    }
}
</style>
