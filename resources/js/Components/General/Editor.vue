<template>
  <div class="w-full bg-gray-50 p-4 shadow">
    <div
      :editor="editor"
      :tippy-options="{ duration: 100 }"
      v-if="editor"
      class="bg-white flex gap-1 flex-wrap"
    >
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
        bold
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
        italic
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
        strike
      </button>
      <div class="text-align flex rounded overflow-hidden">
        <button class="py-1 px-2 border" @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }">
        left
        </button>
        <button class="py-1 px-2 border" @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }">
          center
        </button>
        <button class="py-1 px-2 border" @click="editor.chain().focus().setTextAlign('right').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }">
          right
        </button>
        <button class="py-1 px-2 border" @click="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }">
          justify
        </button>
        <button class="py-1 px-2 border" @click="editor.chain().focus().unsetTextAlign().run()">
          unsetTextAlign
        </button>
      </div>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()">
        insertTable
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().addColumnBefore().run()">
        addColumnBefore
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().addColumnAfter().run()">
        addColumnAfter
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().deleteColumn().run()">
        deleteColumn
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().addRowBefore().run()">
        addRowBefore
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().addRowAfter().run()">
        addRowAfter
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().deleteRow().run()">
        deleteRow
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().deleteTable().run()">
        deleteTable
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().mergeCells().run()">
        mergeCells
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().splitCell().run()">
        splitCell
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleHeaderColumn().run()">
        toggleHeaderColumn
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleHeaderRow().run()">
        toggleHeaderRow
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().toggleHeaderCell().run()">
        toggleHeaderCell
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().mergeOrSplit().run()">
        mergeOrSplit
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().setCellAttribute('colspan', 2).run()">
        setCellAttribute
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().fixTables().run()">
        fixTables
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().goToNextCell().run()">
        goToNextCell
      </button>
      <button class="border rounded hover:bg-gray-200 focus:bg-gray-400 px-2 py-1" @click="editor.chain().focus().goToPreviousCell().run()">
        goToPreviousCell
      </button>
    </div>
    <editor-content :editor="editor" class="border p-3 bg-white my-3" />
  </div>
</template>
  
  <script>
  import StarterKit from '@tiptap/starter-kit'
  import { Editor, EditorContent, BubbleMenu } from '@tiptap/vue-3'
  import Table from '@tiptap/extension-table'
  import TableCell from '@tiptap/extension-table-cell'
  import TableHeader from '@tiptap/extension-table-header'
  import TableRow from '@tiptap/extension-table-row'
  import Paragraph from '@tiptap/extension-paragraph'
  import Gapcursor from '@tiptap/extension-gapcursor'
  import TextAlign from '@tiptap/extension-text-align'
  
  
  export default {
    components: {
      EditorContent,
      BubbleMenu
    },
  
    props: {
      modelValue: {
        type: String,
        default: '',
      },
    },
  
    emits: ['update:modelValue'],
  
    data() {
      return {
        editor: null,
      }
    },
  
    watch: {
      modelValue(value) {
        // HTML
        const isSame = this.editor.getHTML() === value
  
        // JSON
        // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)
  
        if (isSame) {
          return
        }
  
        this.editor.commands.setContent(value, false)
      },
    },
  
    mounted() {
      this.editor = new Editor({
        extensions: [
          StarterKit,
          BubbleMenu,
          Document,
          Paragraph,
          Text,
          Gapcursor,
          Table.configure({
            resizable: true,
          }),
          TableRow,
          TableHeader,
          TableCell,
          TextAlign.configure({
            types: ['heading', 'paragraph'],
          }),
        ],
        content: this.modelValue,
        onUpdate: () => {
          // HTML
          this.$emit('update:modelValue', this.editor.getHTML())
  
          // JSON
          // this.$emit('update:modelValue', this.editor.getJSON())
        },
      })
    },
  
    beforeUnmount() {
      this.editor.destroy()
    },
  }
  </script>

<style lang="scss">
.ProseMirror {
  table {
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    margin: 0;
    overflow: hidden;

    td,
    th {
      min-width: 1em;
      border: 2px solid #ced4da;
      padding: 3px 5px;
      vertical-align: top;
      box-sizing: border-box;
      position: relative;

      > * {
        margin-bottom: 0;
      }
    }

    th {
      font-weight: bold;
      text-align: left;
      background-color: #f1f3f5;
    }

    .selectedCell:after {
      z-index: 2;
      position: absolute;
      content: "";
      left: 0; right: 0; top: 0; bottom: 0;
      background: rgba(200, 200, 255, 0.4);
      pointer-events: none;
    }

    .column-resize-handle {
      position: absolute;
      right: -2px;
      top: 0;
      bottom: -2px;
      width: 4px;
      background-color: #adf;
      pointer-events: none;
    }

    p {
      margin: 0;
    }
  }
}

.tableWrapper {
  padding: 1rem 0;
  overflow-x: auto;
}

.resize-cursor {
  cursor: ew-resize;
  cursor: col-resize;
}
button.is-active {
  background: #333;
  color: #fefefe;
}
</style>