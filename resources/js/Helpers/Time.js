export function UTCToHumanReadable(u, format) {
    return dayjs(u).utc().local().tz(dayjs.tz.guess()).format(format);
}

export function timePlayedSecondsToHours(s) {
    return dayjs.duration({ seconds: s }).asHours().toPrecision(2) + 'H';
}

export function TimeAgo(param){
    return dayjs().to(dayjs(param)) 
}