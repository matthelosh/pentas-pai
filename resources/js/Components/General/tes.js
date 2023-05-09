export const CardHorizontal = {
    template: `
        <div class="w-full bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="row-span-2">
                    <div class="rounded shadow bg-gray-200 w-full h-52 animate-pulse"></div>
                </div>
                <div class="w-full grid grid-rows-4">
                    <div class="rounded shadow bg-gray-200 w-full h-4 animate-pulse"></div>
                    <div class="rounded shadow bg-gray-200 w-full h-6 animate-pulse"></div>
                    <div class="rounded shadow bg-gray-200 w-full h-6 animate-pulse"></div>
                    <div class="rounded shadow bg-gray-200 w-full h-6 animate-pulse"></div>
                </div>
            </div>
        </div>
    `,
    data() {
        name: 'CardHorizontal'
    }
}

export const CardVertical = {
    template: `<div>Component Vertical</div>`,
    data() {
        name: 'CardVertical'
    }
}

export default CardHorizontal