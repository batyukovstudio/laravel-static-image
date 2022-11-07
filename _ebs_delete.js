// Подключение зависимостей
import fs from 'fs'
import path from 'path'
import {
    CONFIG_NAME_FILE,
    SEARCH_EXCLUDES,
    PAGES_FOLDER,
    PREFIX,
    SOURCE_FOLDER,
    FORMAT,
    QUALITY,
    CHECK_WARNING,
    CHECK_PROGRESS,
} from './scripts/constant.js'

let count = 0
function deleteImages(dir) {
    fs.readdirSync(dir).forEach((item) => {
        item = dir + '/' + item
        var stat = fs.statSync(item)
        if (stat && stat.isDirectory() && !SEARCH_EXCLUDES.includes(path.basename(item))) {
            deleteImages(item)
        } else {
            if (item.includes(PREFIX)) {
                fs.unlinkSync(item)
                count++
            }
        }
    })
}
deleteImages(SOURCE_FOLDER)

console.log(`Удалено ${count} файл(ов)`)
