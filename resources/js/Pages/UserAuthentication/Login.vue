<template>
    <main class="flex flex-col text-base rounded-none max-w-[400px]">
      <h1 data-layername="login" class="z-10 self-center mt-0 text-3xl font-semibold text-center text-neutral-900">
        Login
      </h1>
      <form @submit.prevent="handleSubmit">
        <div class="mt-12">
          <label for="email" class="block text-sm font-medium tracking-wide leading-snug text-neutral-900">
            Email address
          </label>
          <input
            id="email"
            type="email"
            v-model="email"
            required
            class="w-full gap-2.5 self-stretch px-3 pt-3 pb-3 mt-1 tracking-wide leading-snug rounded bg-zinc-100 text-neutral-900"
            placeholder="Email address"
          />
        </div>
        <div class="mt-5">
          <label for="password" class="block text-sm font-medium tracking-wide leading-snug text-neutral-900">
            Password
          </label>
          <input
            id="password"
            type="password"
            v-model="password"
            required
            class="w-full gap-2.5 self-stretch px-3 pt-3 pb-3 mt-1 tracking-wide leading-snug rounded bg-zinc-100 text-neutral-900"
            placeholder="Password"
          />
        </div>
        <div class="flex gap-5 justify-between mt-5 w-full text-sm tracking-wide">
          <div class="flex gap-2 text-neutral-600">
            <input type="checkbox" id="stayLoggedIn" v-model="stayLoggedIn" class="w-5 h-5 rounded-md border border-solid border-stone-300" />
            <label for="stayLoggedIn">Biarkan saya tetap masuk</label>
          </div>
          <a href="#" class="font-medium text-right text-blue-500">Lupa password?</a>
        </div>
        <button type="submit" class="w-full gap-2.5 self-stretch px-5 py-3 mt-5 font-medium tracking-wide leading-none text-white bg-cyan-700 rounded-md">
          Login
        </button>
      </form>
      <p class="gap-2.5 self-center px-4 py-1 mt-6 text-sm tracking-wide leading-none text-center bg-white text-neutral-600">
        atau gunakan salah satu opsi berikut
      </p>
      <button @click="loginWithGoogle" class="flex gap-2.5 justify-center items-center px-5 py-3 mt-6 font-medium tracking-wide leading-none bg-white rounded-md border border-solid border-neutral-200 text-neutral-600">
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/80cf95911d47cc2d39f748b95277a1ad09d963798b52be5e34b214a2a7eeb53b?placeholderIfAbsent=true&apiKey=a6a4bb1a991e4a4fa4c25aa0ed6e28da" alt="" class="object-contain shrink-0 self-stretch my-auto w-5 aspect-square" />
        <span class="self-stretch my-auto">Lanjutkan dengan Google</span>
      </button>
<button @click="loginWithFacebook" class="flex gap-2.5 justify-center items-center px-5 py-3 mt-3 font-medium tracking-wide leading-none text-white rounded-md bg-slate-500">
    <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/8db336d584def3affd60866118aff019de05a76d25c1f6c3b532041e137b4661?placeholderIfAbsent=true&apiKey=a6a4bb1a991e4a4fa4c25aa0ed6e28da" alt="" class="object-contain shrink-0 self-stretch my-auto w-5 aspect-square" />
    <span class="self-stretch my-auto">Lanjutkan dengan Facebook</span>
  </button>
  <p class="z-10 self-center mt-16 text-base tracking-wide text-center">
    Belum memiliki akun? <a href="#" class="text-blue-500">Register</a>
  </p>
</main>
</template>

<script>
export default {
data() {
  return {
    email: '',
    password: '',
    stayLoggedIn: false
  }
},
methods: {
  handleSubmit() {
    // Handle form submission
  },
  loginWithGoogle() {
    // Handle Google login
  },
  loginWithFacebook() {
    // Handle Facebook login
  }
}
}
</script>