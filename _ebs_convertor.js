// Подключение зависимостей
import fs from 'fs'
import path from 'path'
import { exit } from 'process'
import { JSDOM } from 'jsdom'
import sharp from 'sharp'

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

let IMAGES = []
let count = 0
function searchImageInCode(dir) {
    fs.readdirSync(dir).forEach((item) => {
        item = `${dir}/${item}`
        const _item = fs.statSync(item)
        if (_item && _item.isDirectory()) {
            searchImageInCode(item)
        } else {
            if (item.endsWith('.blade.php')) {
                const text = fs.readFileSync(item, 'utf8')
                if (text.includes('x-image')) {
                    const code = new JSDOM(text)
                    code.window.document.querySelectorAll('x-image').forEach((image) => {
                        image.setAttribute('path', item)
                        IMAGES.push(image)
                    })
                }
            }
        }
    })
}

function init() {
    if (typeof PAGES_FOLDER === 'string') {
        searchImageInCode(PAGES_FOLDER)
    } else {
        PAGES_FOLDER.forEach((folder) => {
            searchImageInCode(folder)
        })
    }
    if (IMAGES.length > 0) {
        IMAGES.forEach((image) => {
            analysisImage(image)
        })
        console.log(`Сгенерировано ${count} файл(ов)`)
    } else {
        console.log('В коде не было найдено ниодного тега "<x-image>"')
    }
}

function analysisImage(image) {
    let src = image.getAttribute('src')
    let format = image.getAttribute('format') || FORMAT || 'webp'
    let quality = Number(image.getAttribute('quality')) || QUALITY || 80
    let sizes = image.getAttribute('sizes')
        ? image
              .getAttribute('sizes')
              .replace(/[a-zа-яё:]/gi, '')
              .split(' ')
        : null

    if (CHECK_WARNING) {
        checkingWarning(image)
    }
    if (sizes) {
        sizes.forEach((size) => {
            generateImage(src, quality, format, Number(size))
        })
    } else {
        generateImage(src, quality, format)
    }
}
function checkingWarning(image) {
    if (!image.getAttribute('alt')) {
        console.log(
            `Отсутствует атрибут "alt" у картинки ${image.getAttribute('src')} в файле ${image.getAttribute('path')}`
        )
    }
    if (!image.getAttribute('width')) {
        console.log(
            `Отсутствует атрибут "width" у картинки ${image.getAttribute('src')} в файле ${image.getAttribute('path')}`
        )
    }
    if (!image.getAttribute('height')) {
        console.log(
            `Отсутствует атрибут "height" у картинки ${image.getAttribute('src')} в файле ${image.getAttribute('path')}`
        )
    }
    if (!image.getAttribute('loaging')) {
        console.log(
            `Отсутствует атрибут "loaging="lazy"" у картинки ${image.getAttribute('src')} в файле ${image.getAttribute(
                'path'
            )}`
        )
    }
}

function generateImage(src, quality, format, size = null) {
    const filename = path.basename(src, path.extname(src))
    const pathname = path.dirname(src) + '/'
    if (format.includes('webp')) {
        count++
        const _sharp = sharp(`${SOURCE_FOLDER}${src}`).webp({ quality: quality })
        if (size) {
            _sharp.resize({
                width: size,
                fit: sharp.fit.cover,
            })
        }
        _sharp.toFile(`${SOURCE_FOLDER}${pathname}${PREFIX}${filename}${size !== null ? '_' + size : ''}.webp`)
    }
    if (format.includes('avif')) {
        count++
        const _sharp = sharp(`${SOURCE_FOLDER}${src}`).avif({ quality: quality })
        if (size) {
            _sharp.resize({
                width: size,
                fit: sharp.fit.cover,
            })
        }
        _sharp.toFile(`${SOURCE_FOLDER}${pathname}${PREFIX}${filename}${size !== null ? '_' + size : ''}.avif`)
    }
}
init()
