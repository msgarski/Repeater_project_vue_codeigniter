import moment from 'moment'

export default {
    demandFormatDate(){
        const format = 'YYYY-MM-DD HH:mm:ss';
        return format;
    },
    getToday(){
        return moment().format(this.demandFormatDate());
    },
    getDatePlusDays(days){
        const newDate = moment().add(days, 'days');
        return newDate.format(this.demandFormatDate());
    },
    getDatePlusMinutes(minutes){
        const newDate = moment().add(minutes, 'minutes');
        return newDate.format(this.demandFormatDate());
    }





}