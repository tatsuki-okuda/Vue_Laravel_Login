<template>
  <app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Blog
        </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
          <jet-form-section @submitted="editBlog">
              <template #title>Blog更新</template>
              <template #description>Blogの更新を行います</template>
              <template #form>

                  <div class="col-span-6 sm:col-span-4">
                    <jet-label for="title" value="タイトル" />
                    <jet-input
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                    />
                    <!-- <jet-input-error :message="form.error('title')" class="mt-2" /> -->
                    
                  </div>
                  <div class="col-span-6 sm:col-span-4">
                    <jet-label for="content" value="コンテント" />
                    <!-- <textarea v-model="form.content" class="mt-1 block w-full form-input rounded-md shadow-sm"></textarea> -->
                    <div>
                        <ckeditor
                            :editor="editor"
                            v-model="form.content"
                            :config="editorConfig"
                        ></ckeditor>
                    </div>
  
                    <!-- <jet-input-error :message="form.error('content')" class="mt-2" /> -->
                  </div>
              </template>
              <template #actions>
                <jet-button class="bg-blue-700 text-base">
                  更新
                </jet-button>
              </template>
          </jet-form-section>

      </div>
    </div>

  </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetFormSection from "@/Jetstream/FormSection";
    import JetInput from "@/Jetstream/Input";
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetInputError from "@/Jetstream/InputError";
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


    export default {
        props:['blog'],
        components: {
            AppLayout,
            JetFormSection,
            JetInput,
            JetLabel,
            JetButton,
            JetInputError,
            ClassicEditor
        },
        data() {
          return {
            form: this.$inertia.form(
                {
                  _method: "PUT",
                  title: this.blog.title,
                  content: this.blog.content,
                },
                {
                  bag: "blogUpdate",
                  resetOnSuccess: false,
                }
            ),
            editor: ClassicEditor,
            editorConfig: {
                language: 'ja'
            }
          };
        },
        methods:{
          editBlog(){
            this.form.post(route("blog.update",this.blog.id));
          }
        }
    }
</script>