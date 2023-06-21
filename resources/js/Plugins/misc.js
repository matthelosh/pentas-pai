import * as _ from 'lodash-es'

export const imgUrl = (url) => {
    if (url.includes('=')) {
        let splited = url.split('=')
        return `https://drive.google.com/uc?export=view&id=${splited[splited.length-1]}`
    } else {
        return url[0] == '/' ? url : '/'+url
    }
}

export const paginate = (datas, currentPage) => {
    let pages = _.chunk(datas, 10)

    return { current: pages[currentPage-1], pageCount: pages.length, dataLength: datas.length}
}

export const tanggal = (date) => {
    const tanggal = new Date(date)
    const bulans = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    return tanggal.getDate()+' '+bulans[tanggal.getMonth()]+' '+tanggal.getFullYear()
}

export default {imgUrl}