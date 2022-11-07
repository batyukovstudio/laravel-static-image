// Объявление дефолтных переменных
import fs from 'fs'
import { exit } from 'process'
const CONFIG_NAME_FILE = 'ebs.config.json'
let SEARCH_EXCLUDES = 'node_modules'
let PAGES_FOLDER = 'resources/views'
let PREFIX = '_ebs_'
let SOURCE_FOLDER = 'public'
let FORMAT = 'webp'
let QUALITY = 80
let CHECK_WARNING = true
let CHECK_PROGRESS = true
let SCREENS = {
    xs: 320,
    sm: 640,
    md: 768,
    lg: 1024,
    xl: 1280,
    xxl: 1536,
}
switch (fs.existsSync(CONFIG_NAME_FILE)) {
    case true:
        let isError = false
        const configFile = JSON.parse(fs.readFileSync(CONFIG_NAME_FILE, 'utf8'))
        SEARCH_EXCLUDES = configFile['searchExcludes'] || SEARCH_EXCLUDES
        PAGES_FOLDER = configFile['pageFolder'] || PAGES_FOLDER
        SOURCE_FOLDER = configFile['sourceFolder'] || SOURCE_FOLDER
        PREFIX = configFile['prefix'] || PREFIX
        FORMAT = configFile['format'] || FORMAT
        QUALITY = configFile['quality'] || QUALITY
        CHECK_WARNING = configFile['checkWarning'] || CHECK_WARNING
        CHECK_PROGRESS = configFile['checkProgress'] || CHECK_PROGRESS
        SCREENS = configFile['screens'] || SCREENS

        if (typeof SCREENS !== 'object') {
            isError = true
            console.log('Допустимый тип для "screens": "object" ')
        }

        if (typeof SEARCH_EXCLUDES !== 'string' && !Array.isArray(SEARCH_EXCLUDES)) {
            isError = true
            console.log('Допустимый тип для "searchExcludes": "string" или "array" ')
        }

        if (typeof PAGES_FOLDER !== 'string' && !Array.isArray(PAGES_FOLDER)) {
            isError = true
            console.log('Допустимый тип для "pageFolder": "string" или "array" ')
        }

        if (typeof SOURCE_FOLDER !== 'string') {
            isError = true
            console.log('Допустимый тип для "sourceFolder": "string"')
        }

        if (typeof PREFIX !== 'string') {
            isError = true
            console.log('Допустимый тип для "prefix": "string"')
        }

        if (typeof FORMAT !== 'string' && !Array.isArray(FORMAT)) {
            isError = true
            console.log('Допустимый тип для "prefix": "string" или "array"')
        }

        if (typeof QUALITY !== 'number') {
            isError = true
            console.log('Допустимый тип для "quality": "number"')
        }

        if (typeof CHECK_WARNING !== 'boolean') {
            isError = true
            console.log('Допустимый тип для "checkWarning": "boolean"')
        }

        if (typeof CHECK_PROGRESS !== 'boolean') {
            isError = true
            console.log('Допустимый тип для "checkProgress": "boolean"')
        }
        if (isError) {
            exit()
        }
        break
    case false:
        console.log('Отсутствует файл конфигурации, все значения будут дефолтными')
}

export {
    CONFIG_NAME_FILE,
    SEARCH_EXCLUDES,
    PAGES_FOLDER,
    PREFIX,
    SOURCE_FOLDER,
    FORMAT,
    QUALITY,
    CHECK_WARNING,
    CHECK_PROGRESS,
}
