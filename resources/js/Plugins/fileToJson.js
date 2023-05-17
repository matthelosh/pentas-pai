import { read, utils } from 'xlsx'

export const readExcel = (file, sheetNumber) => {
    alert('halo')
    let reader = new FileReader()
    console.log(file)
    let sheetIndex = sheetNumber ? sheetNumber : 0
    reader.onload = async (e) => {
        let workbook = await read(e.target.result)
        let datas = await utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]])
        // console.log(file)
        return datas

    }
    reader.readAsArrayBuffer(file)
}


export default {readExcel}