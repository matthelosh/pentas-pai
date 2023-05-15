export const imgUrl = (url) => {
    if (url.includes('=')) {
        let splited = url.split('=')
        return `https://drive.google.com/uc?export=view&id=${splited[splited.length-1]}`
    } else {
        return url[0] == '/' ? url : '/'+url
    }
}