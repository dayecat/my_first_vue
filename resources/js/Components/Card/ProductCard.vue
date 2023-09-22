<script>
import { router } from '@inertiajs/vue3';


export default {
  props: {
    productInfo: {
      type: Object,
      required: true,
      default: () => {
        return {};
      },
    },
  },
  data() {
    return {
      num: 1,
    };
  },
  methods: {
    plus() {
      this.num++;
    },
    minus() {
      const { num } = this;
      if (num <= 1) return;
      this.num--;
    },
    inputNum() {
      const { num } = this;
      if (num <= 0) {
        this.num = 1;
      }
    },
    addCart() {
        const { productInfo,num } = this;
        // 交給組件送資料
        router.visit(route('product.addCart'), { method: 'post', data: { id: productInfo.id, qty: num},
    preserveState: trun });
    // 交給頁面去處理
    },
  },
};
</script>

<template>
  <section class="card">
    <img :src="productInfo.img_path" class="w-full aspect-[4/3] object-cover" alt="">
    <h3 class="name">商品名稱:{{ productInfo.name }}</h3>
    <h3 class="price">商品價格:${{ productInfo.price }}</h3>
    <h3 class="desc">商品描述:{{ productInfo.desc }}</h3>
    <div class="flex justify-between items-stretch">
      <div class="flex items-center w-2/3 border border-black">
        <button type="button" class="grow text-center" @click="minus()">-</button>
        <input type="number" class="w-2/3  border-x-[1px] border-black border-y-0 outline-0 focus:right-0 grow text-center">
        <button type="button" class="grow text-center" @click="plus()">+ </button>
      </div>
      <button type="button" class="w-1/3 border bg-white" @click="addCart()">加入購物車</button>
    </div>
  </section>
</template>

<style lang="scss" scoped>
.card {
        @apply w-[calc(25%-22.5px)] border p-6;
    }
</style>
