export const printContsCard = (lomba) => {
    let win = window.open("","","width=700,height=800,lft=200,top=100")
    win.document.write('<h1>Kartu Peserta</h1>')

    let tr = ''
    lomba.pesertas.forEach((peserta,p) => {
        tr += `<tr>
            <td>${peserta.nama}</td>
        </tr>`
    })

    let table = `<table border="1" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            ${tr}
        </tbody>
    </table>`

    let html = `<!doctype html>
                <html>
                    <head>
                        <title>Kartu Peserta</title>
                    </head>
                    <body>
                        ${table}
                    </body>
                </html>
    `
    win.document.write(html)
}

export default { printContsCard }