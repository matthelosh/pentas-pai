import { createApp } from "vue";
import ConfirmDialog from "@/Components/General/ConfirmDialog.vue";

export default {
    install(app) {
        app.config.globalProperties.$dialog = (options) => {
            return new Promise((resolve) => {
                const dialogApp = createApp(ConfirmDialog, {
                    ...options,
                    onConfirm: () => {
                        resolve(true)
                        unmount()
                    },
                    onClose: () => {
                        resolve(false)
                        unmount()
                    }
                })

                const container = document.createElement('div');
                document.body.appendChild(container);

                

                const unmount = () => {
                    dialogApp.unmount()
                    document.body.removeChild(container)
                }

                dialogApp.mount(container)
            })
        }
    }
}