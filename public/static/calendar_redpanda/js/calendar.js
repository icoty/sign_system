/*
*
*/
var lunarInfo = new Array(
		0x04bd8, 0x04ae0, 0x0a570, 0x054d5, 0x0d260, 0x0d950, 0x16554, 0x056a0, 0x09ad0, 0x055d2,
		0x04ae0, 0x0a5b6, 0x0a4d0, 0x0d250, 0x1d255, 0x0b540, 0x0d6a0, 0x0ada2, 0x095b0, 0x14977,
		0x04970, 0x0a4b0, 0x0b4b5, 0x06a50, 0x06d40, 0x1ab54, 0x02b60, 0x09570, 0x052f2, 0x04970,
		0x06566, 0x0d4a0, 0x0ea50, 0x06e95, 0x05ad0, 0x02b60, 0x186e3, 0x092e0, 0x1c8d7, 0x0c950,
		0x0d4a0, 0x1d8a6, 0x0b550, 0x056a0, 0x1a5b4, 0x025d0, 0x092d0, 0x0d2b2, 0x0a950, 0x0b557,
		0x06ca0, 0x0b550, 0x15355, 0x04da0, 0x0a5b0, 0x14573, 0x052b0, 0x0a9a8, 0x0e950, 0x06aa0,
		0x0aea6, 0x0ab50, 0x04b60, 0x0aae4, 0x0a570, 0x05260, 0x0f263, 0x0d950, 0x05b57, 0x056a0,
		0x096d0, 0x04dd5, 0x04ad0, 0x0a4d0, 0x0d4d4, 0x0d250, 0x0d558, 0x0b540, 0x0b6a0, 0x195a6,
		0x095b0, 0x049b0, 0x0a974, 0x0a4b0, 0x0b27a, 0x06a50, 0x06d40, 0x0af46, 0x0ab60, 0x09570,
		0x04af5, 0x04970, 0x064b0, 0x074a3, 0x0ea50, 0x06b58, 0x055c0, 0x0ab60, 0x096d5, 0x092e0,
		0x0c960, 0x0d954, 0x0d4a0, 0x0da50, 0x07552, 0x056a0, 0x0abb7, 0x025d0, 0x092d0, 0x0cab5,
		0x0a950, 0x0b4a0, 0x0baa4, 0x0ad50, 0x055d9, 0x04ba0, 0x0a5b0, 0x15176, 0x052b0, 0x0a930,
		0x07954, 0x06aa0, 0x0ad50, 0x05b52, 0x04b60, 0x0a6e6, 0x0a4e0, 0x0d260, 0x0ea65, 0x0d530,
		0x05aa0, 0x076a3, 0x096d0, 0x04bd7, 0x04ad0, 0x0a4d0, 0x1d0b6, 0x0d250, 0x0d520, 0x0dd45,
		0x0b5a0, 0x056d0, 0x055b2, 0x049b0, 0x0a577, 0x0a4b0, 0x0aa50, 0x1b255, 0x06d20, 0x0ada0,
		0x14b63);

var solarMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var Gan = new Array("甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
var Zhi = new Array("子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥");
var Animals = new Array("鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪");
var solarTerm = new Array("小寒", "大寒", "立春", "雨水", "惊蛰", "春分", "清明", "谷雨", "立夏", "小满", "芒种", "夏至", "小暑", "大暑", "立秋", "处暑", "白露", "秋分", "寒露", "霜降", "立冬", "小雪", "大雪", "冬至")
var sTermInfo = new Array(0, 21208, 42467, 63836, 85337, 107014, 128867, 150921, 173149, 195551, 218072, 240693, 263343, 285989, 308563, 331033, 353350, 375494, 397447, 419210, 440795, 462224, 483532, 504758)
var nStr1 = new Array('日', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十')
var nStr2 = new Array('初', '十', '廿', '卅', ' ')
var monthName = new Array("正月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "冬月", "腊月")

var jcName0 = new Array('建', '除', '满', '平', '定', '执', '破', '危', '成', '收', '开', '闭');
var jcName1 = new Array('闭', '建', '除', '满', '平', '定', '执', '破', '危', '成', '收', '开');
var jcName2 = new Array('开', '闭', '建', '除', '满', '平', '定', '执', '破', '危', '成', '收');
var jcName3 = new Array('收', '开', '闭', '建', '除', '满', '平', '定', '执', '破', '危', '成');
var jcName4 = new Array('成', '收', '开', '闭', '建', '除', '满', '平', '定', '执', '破', '危');
var jcName5 = new Array('危', '成', '收', '开', '闭', '建', '除', '满', '平', '定', '执', '破');
var jcName6 = new Array('破', '危', '成', '收', '开', '闭', '建', '除', '满', '平', '定', '执');
var jcName7 = new Array('执', '破', '危', '成', '收', '开', '闭', '建', '除', '满', '平', '定');
var jcName8 = new Array('定', '执', '破', '危', '成', '收', '开', '闭', '建', '除', '满', '平');
var jcName9 = new Array('平', '定', '执', '破', '危', '成', '收', '开', '闭', '建', '除', '满');
var jcName10 = new Array('满', '平', '定', '执', '破', '危', '成', '收', '开', '闭', '建', '除');
var jcName11 = new Array('除', '满', '平', '定', '执', '破', '危', '成', '收', '开', '闭', '建');

function jcr(d) {
    var jcrjx;
    if (d == '建') jcrjx = '<span style="vertical-align:middle; margin:1px; font-size:12px"><img src="images/yi.gif"/></span>&nbsp;出行.上任.会友.上书.见工<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;动土.开仓.嫁娶.纳采';
    if (d == '除') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;除服.疗病.出行.拆卸.入宅<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;求官.上任.开张.搬家.探病';
    if (d == '满') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祈福.祭祀.结亲.开市.交易<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;服药.求医.栽种.动土.迁移';
    if (d == '平') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祭祀.修填.涂泥.余事勿取<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;移徙.入宅.嫁娶.开市.安葬';
    if (d == '定') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;易.立券.会友.签约.纳畜<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;种植.置业.卖田.掘井.造船';
    if (d == '执') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祈福.祭祀.求子.结婚.立约<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;开市.交易.搬家.远行';
    if (d == '破') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;求医.赴考.祭祀.余事勿取<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;动土.出行.移徙.开市.修造';
    if (d == '危') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;经营.交易.求官.纳畜.动土<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;登高.行船.安床.入宅.博彩';
    if (d == '成') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祈福.入学.开市.求医.成服<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;词讼.安门.移徙';
    if (d == '收') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祭祀.求财.签约.嫁娶.订盟<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;开市.安床.安葬.入宅.破土';
    if (d == '开') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;疗病.结婚.交易.入仓.求职<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;安葬.动土.针灸';
    if (d == '闭') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;祭祀.交易.收财.安葬<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;宴会.安床.出行.嫁娶.移徙';
    return(jcrjx);
}

//国历节日  *表示放假日
var sFtv = new Array(
        "0101*元旦",

        "0214  情人节",

        "0303  全国爱耳日",
        "0308  妇女节",
        "0312  植树节",
        "0315  消费者权益保护日",
        "0321  世界森林日",

        "0401  愚人节",
        "0407  世界卫生日",

        "0501*国际劳动节",
        "0504  中国青年节",
        "0508  世界红十字日",
        "0519  汶川地震哀悼日",
        "0531  世界无烟日",

        "0601  国际儿童节",
        "0623  国际奥林匹克日",
        "0626  国际反毒品日",

        "0701  建党节 香港回归",
        "0707  抗日战争纪念日",
        "0711  世界人口日",

        "0801  八一建军节",
        "0815  日本宣布无条件投降",

        "0909  毛泽东逝世纪念日",
        "0910  教师节",
        "0918  九·一八事变纪念日",
        "0920  国际爱牙日",
        "0928  孔子诞辰",

        "1001*国庆节",
        "1010  辛亥革命纪念日",
        "1031  万圣节",

        "1110  世界青年节",
        "1117  国际大学生节",

        "1201  世界艾滋病日",
        "1212  西安事变纪念日",
        "1213  南京大屠杀",
        "1220  澳门回归纪念日",
        "1224  平安夜",
        "1225  圣诞节",
        "1226  毛泽东诞辰")
//农历节日  *表示放假日
var lFtv = new Array(
        "0101*春节",
        "0102*大年初二",
        "0103*大年初三",
        "0104*大年初四",
        "0105*大年初五",
        "0106*大年初六",
        "0107*大年初七",
        "0115  元宵节",
        "0202  龙抬头",
        "0404  寒食节",
        "0408  佛诞节 ",
        "0505*端午节",
        "0606  天贶节",
        "0707  七夕情人节",
        "0714  鬼节(南方)",
        "0715  中元节",
        "0815*中秋节",
        "0909  重阳节",
        "1001  祭祖节",
        "1208  腊八节",
        "1223  过小年",
        "1229*腊月二十九",
        "0100*除夕");
//某月的第几个星期几; 5,6,7,8 表示到数第 1,2,3,4 个星期几
var wFtv = new Array(
        "0150  世界麻风日",
        "0520  母亲节",
        "0530  全国助残日",
        "0630  父亲节",
        "1144  感恩节")

/*****************************************************************************
 日期计算
 *****************************************************************************/

//====================================== 返回农历 y年的总天数
function lYearDays(y) {
	var i,
	sum = 348;
	for (i = 0x8000; i > 0x8; i >>= 1)
		sum += (lunarInfo[y - 1900] & i) ? 1 : 0;
	return (sum + leapDays(y));
}

//====================================== 返回农历 y年闰月的天数
function leapDays(y) {
	if (leapMonth(y))
		return ((lunarInfo[y - 1900] & 0x10000) ? 30 : 29);
	else
		return (0);
}

//====================================== 返回农历 y年闰哪个月 1-12 , 没闰返回 0
function leapMonth(y) {
    return(lunarInfo[y - 1900] & 0xf);
}

//====================================== 返回农历 y年m月的总天数
function monthDays(y, m) {
	return ((lunarInfo[y - 1900] & (0x10000 >> m)) ? 30 : 29);
}

//====================================== 算出农历, 传入日期控件, 返回农历日期控件
//                                       该控件属性有 .year .month .day .isLeap
function Lunar(objDate) {
	
	var i,
	leap = 0,
	temp = 0;
	var offset = (Date.UTC(objDate.getFullYear(), objDate.getMonth(), objDate.getDate()) - Date.UTC(1900, 0, 31)) / 86400000;
	
	for (i = 1900; i < 2050 && offset > 0; i++) {
		temp = lYearDays(i);
		offset -= temp;
	}
	
	if (offset < 0) {
		offset += temp;
		i--;
	}
	
	this.year = i;
	
	leap = leapMonth(i); //闰哪个月
	this.isLeap = false;
	
	for (i = 1; i < 13 && offset > 0; i++) {
		//闰月
		if (leap > 0 && i == (leap + 1) && this.isLeap == false) {
			--i;
			this.isLeap = true;
			temp = leapDays(this.year);
		} else {
			temp = monthDays(this.year, i);
		}
		
		//解除闰月
		if (this.isLeap == true && i == (leap + 1))
			this.isLeap = false;
		
		offset -= temp;
	}
	
	if (offset == 0 && leap > 0 && i == leap + 1)
		if (this.isLeap) {
			this.isLeap = false;
		} else {
			this.isLeap = true;
			--i;
		}
	
	if (offset < 0) {
		offset += temp;
		--i;
	}
	
	this.month = i;
	this.day = offset + 1;
}

//==============================返回公历 y年某m+1月的天数
function solarDays(y, m) {
	if (m == 1)
		return (((y % 4 == 0) && (y % 100 != 0) || (y % 400 == 0)) ? 29 : 28);
	else
		return (solarMonth[m]);
}
//============================== 传入 offset 返回干支, 0=甲子
function cyclical(num) {
	return (Gan[num % 10] + Zhi[num % 12]);
}
//============================== 阴历属性
//============================== 阴历属性
function calElement(sYear, sMonth, sDay, week, lYear, lMonth, lDay, isLeap, cYear, cMonth, cDay) {
	
	this.isToday = false;
	//瓣句
	this.sYear = sYear; //公元年4位数字
	this.sMonth = sMonth; //公元月数字
	this.sDay = sDay; //公元日数字
	this.week = week; //星期, 1个中文
	//农历
	this.lYear = lYear; //公元年4位数字
	this.lMonth = lMonth; //农历月数字
	this.lDay = lDay; //农历日数字
	this.isLeap = isLeap; //是否为农历闰月?
	//八字
	this.cYear = cYear; //年柱, 2个中文
	this.cMonth = cMonth; //月柱, 2个中文
	this.cDay = cDay; //日柱, 2个中文
	
	this.color = '';
	
	this.lunarFestival = ''; //农历节日
	this.solarFestival = ''; //公历节日
	this.solarTerms = ''; //节气
}

//===== 某年的第n个节气为几日(从0小寒起算)
function sTerm(y, n) {
	if (y == 2009 && n == 2) {
		sTermInfo[n] = 43467
	}
	var offDate = new Date((31556925974.7 * (y - 1900) + sTermInfo[n] * 60000) + Date.UTC(1900, 0, 6, 2, 5));
	return (offDate.getUTCDate());
}


//============================== 返回阴历 (y年,m+1月)
function cyclical6(num, num2) {
    if (num == 0) return(jcName0[num2]);
    if (num == 1) return(jcName1[num2]);
    if (num == 2) return(jcName2[num2]);
    if (num == 3) return(jcName3[num2]);
    if (num == 4) return(jcName4[num2]);
    if (num == 5) return(jcName5[num2]);
    if (num == 6) return(jcName6[num2]);
    if (num == 7) return(jcName7[num2]);
    if (num == 8) return(jcName8[num2]);
    if (num == 9) return(jcName9[num2]);
    if (num == 10) return(jcName10[num2]);
    if (num == 11) return(jcName11[num2]);
}
function CalConv2(yy, mm, dd, y, d, m, dt, nm, nd) {
    var dy = d + '' + dd
    if ((yy == 0 && dd == 6) || (yy == 6 && dd == 0) || (yy == 1 && dd == 7) || (yy == 7 && dd == 1) || (yy == 2 && dd == 8) || (yy == 8 && dd == 2) || (yy == 3 && dd == 9) || (yy == 9 && dd == 3) || (yy == 4 && dd == 10) || (yy == 10 && dd == 4) || (yy == 5 && dd == 11) || (yy == 11 && dd == 5)) {
        return '<FONT color=#0000A0>日值岁破 大事不宜</font>';
    }
    else if ((mm == 0 && dd == 6) || (mm == 6 && dd == 0) || (mm == 1 && dd == 7) || (mm == 7 && dd == 1) || (mm == 2 && dd == 8) || (mm == 8 && dd == 2) || (mm == 3 && dd == 9) || (mm == 9 && dd == 3) || (mm == 4 && dd == 10) || (mm == 10 && dd == 4) || (mm == 5 && dd == 11) || (mm == 11 && dd == 5)) {
        return '<FONT color=#0000A0>日值月破 大事不宜</font>';
    }
    else if ((y == 0 && dy == '911') || (y == 1 && dy == '55') || (y == 2 && dy == '111') || (y == 3 && dy == '75') || (y == 4 && dy == '311') || (y == 5 && dy == '95') || (y == 6 && dy == '511') || (y == 7 && dy == '15') || (y == 8 && dy == '711') || (y == 9 && dy == '35')) {
        return '<FONT color=#0000A0>日值上朔 大事不宜</font>';
    }
    else if ((m == 1 && dt == 13) || (m == 2 && dt == 11) || (m == 3 && dt == 9) || (m == 4 && dt == 7) || (m == 5 && dt == 5) || (m == 6 && dt == 3) || (m == 7 && dt == 1) || (m == 7 && dt == 29) || (m == 8 && dt == 27) || (m == 9 && dt == 25) || (m == 10 && dt == 23) || (m == 11 && dt == 21) || (m == 12 && dt == 19)) {
        return '<FONT color=#0000A0>日值杨公十三忌 大事不宜</font>';
    }
    else {
        return 0;
    }
}


function calendar(y, m) {

	var sDObj,
	lDObj,
	lY,
	lM,
	lD = 1,
	lL,
	lX = 0,
	tmp1,
	tmp2,
	tmp3;
	var cY,
	cM,
	cD; //年柱,月柱,日柱
	var lDPOS = new Array(3);
	var n = 0;
	var firstLM = 0;
	
	sDObj = new Date(y, m, 1, 0, 0, 0, 0); //当月一日日期
	this.length = solarDays(y, m); //公历当月天数
	this.firstWeek = sDObj.getDay(); //公历当月1日星期几

////////年柱 1900年立春后为庚子年(60进制36)
	if (m < 2)
		cY = cyclical(y - 1900 + 36 - 1);
	else
		cY = cyclical(y - 1900 + 36);
	
	var term2 = sTerm(y, 2); //立春日期
	
	////////月柱 1900年1月小寒以前为 丙子月(60进制12)
	var firstNode = sTerm(y, m * 2) //返回当月「节」为几日开始
		cM = cyclical((y - 1900) * 12 + m + 12);
   
    lM2 = (y - 1900) * 12 + m + 12;
    //当月一日与 1900/1/1 相差天数
    //1900/1/1与 1970/1/1 相差25567日, 1900/1/1 日柱为甲戌日(60进制10)
    var dayCyclical = Date.UTC(y, m, 1, 0, 0, 0, 0) / 86400000 + 25567 + 10;

    for (var i = 0; i < this.length; i++) {

        if (lD > lX) {
            sDObj = new Date(y, m, i + 1);    //当月一日日期
            lDObj = new Lunar(sDObj);     //农历
            lY = lDObj.year;           //农历年
            lM = lDObj.month;          //农历月
            lD = lDObj.day;            //农历日
            lL = lDObj.isLeap;         //农历是否闰月
            lX = lL ? leapDays(lY) : monthDays(lY, lM); //农历当月最后一天

            if (n == 0) firstLM = lM;
            lDPOS[n++] = i - lD + 1;
        }

        //依节气调整二月分的年柱, 以立春为界
        if (m == 1 && ((i + 1) == term2 || lD == 1))
			cY = cyclical(y - 1900 + 36);
		
        if (lD == 1) {
			cM = cyclical((y - 1900) * 12 + m + 13);
		}
       
        //日柱
        cD = cyclical(dayCyclical + i);
        lD2 = (dayCyclical + i);

        this[i] = new calElement(y, m + 1, i + 1, nStr1[(i + this.firstWeek) % 7],
                lY, lM, lD++, lL,
                cY, cM, cD);

    }

    //节气
    tmp1 = sTerm(y, m * 2) - 1;
    tmp2 = sTerm(y, m * 2 + 1) - 1;
    this[tmp1].solarTerms = solarTerm[m * 2];
    this[tmp2].solarTerms = solarTerm[m * 2 + 1];
    if (m == 3) this[tmp1].color = 'red'; //清明颜色

  //公历节日
	for (i in sFtv)
		if (sFtv[i].match(/^(\d{2})(\d{2})([\s\*])(.+)$/))
			if (Number(RegExp.$1) == (m + 1)) {
				this[Number(RegExp.$2) - 1].solarFestival += RegExp.$4 + ' ';
				if (RegExp.$3 == '*')
					this[Number(RegExp.$2) - 1].color = 'red';
			}

	//月周节日
	for (i in wFtv)
		if (wFtv[i].match(/^(\d{2})(\d)(\d)([\s\*])(.+)$/))
			if (Number(RegExp.$1) == (m + 1)) {
				tmp1 = Number(RegExp.$2);
				tmp2 = Number(RegExp.$3);
				if (tmp1 < 5)
					this[((this.firstWeek > tmp2) ? 7 : 0) + 7 * (tmp1 - 1) + tmp2 - this.firstWeek].solarFestival += RegExp.$5 + ' ';
				else {
					tmp1 -= 5;
					tmp3 = (this.firstWeek + this.length - 1) % 7; //当月最后一天星期?
					this[this.length - tmp3 - 7 * tmp1 + tmp2 - (tmp2 > tmp3 ? 7 : 0) - 1].solarFestival += RegExp.$5 + ' ';
				}
			}
	//农历节日
	for (i in lFtv)
		if (lFtv[i].match(/^(\d{2})(.{2})([\s\*])(.+)$/)) {
			tmp1 = Number(RegExp.$1) - firstLM;
			if (tmp1 == -11)
				tmp1 = 1;
			if (tmp1 >= 0 && tmp1 < n) {
				tmp2 = lDPOS[tmp1] + Number(RegExp.$2) - 1;
				if (tmp2 >= 0 && tmp2 < this.length && this[tmp2].isLeap != true) {
					this[tmp2].lunarFestival += RegExp.$4 + ' ';
					if (RegExp.$3 == '*')
						this[tmp2].color = 'red';
				}
			}
		}
	//复活节只出现在3或4月
	if (m == 2 || m == 3) {
		var estDay = new easter(y);
		if (m == estDay.m)
			this[estDay.d - 1].solarFestival = this[estDay.d - 1].solarFestival + ' 复活节';
	}

	//黑色星期五
	if ((this.firstWeek + 12) % 7 == 5)
		this[12].solarFestival += '黑色星期五';
	
	//今日
	if (y == tY && m == tM)
		this[tD - 1].isToday = true;
}

//======================================= 返回该年的复活节(春分后第一次满月周后的第一主日)
//======================================= 返回该年的复活节(春分后第一次满月周后的第一主日)
function easter(y) {
	
	var term2 = sTerm(y, 5); //取得春分日期
	var dayTerm2 = new Date(Date.UTC(y, 2, term2, 0, 0, 0, 0)); //取得春分的公历日期控件(春分一定出现在3月)
	var lDayTerm2 = new Lunar(dayTerm2); //取得取得春分农历
	
	if (lDayTerm2.day < 15) //取得下个月圆的相差天数
		var lMlen = 15 - lDayTerm2.day;
	else
		var lMlen = (lDayTerm2.isLeap ? leapDays(y) : monthDays(y, lDayTerm2.month)) - lDayTerm2.day + 15;
	
	//一天等于 1000*60*60*24 = 86400000 毫秒
	var l15 = new Date(dayTerm2.getTime() + 86400000 * lMlen); //求出第一次月圆为公历几日
	var dayEaster = new Date(l15.getTime() + 86400000 * (7 - l15.getUTCDay())); //求出下个周日
	
	this.m = dayEaster.getUTCMonth();
	this.d = dayEaster.getUTCDate();

}
//====================== 中文日期
function cDay(d, m,dt) {
	var s;
	switch (d) {
	case 1:
		s = monthName[m - 1];
		if(dt){
		s = '初一';
		}
		break;
	case 10:
		s = '初十';
		break;
	case 20:
		s = '二十';
		break;
	case 30:
		s = '三十';
		break;
	default:
		s = nStr2[Math.floor(d / 10)];
		s += nStr1[d % 10];
	}
	return (s);
}
var cld;

//---没有问题

//存放节假日
var hDays = [];
function drawCld(SY, SM) {

    var i,sD,s,size;
    cld = new calendar(SY, SM);
    var rows = null;
    $.ajax({
        url:'getcalendar',
        type:'POST',
        data:{"year":SY,'month':SM+1},
        cache:false,
        async:false,
        dataType:'json',
        success:function(data) {
            if (data.isError === "1") {
            } else {
                 rows = data.data;
                 console.log('测试输出',data,rows);
            }
        },
    });
  
    $("#GZ")[0].innerHTML = '  农历' + cyclical(SY - 1900 + 36) + '年&nbsp;【' + Animals[(SY - 4) % 12] + '年】';

    for (i = 0; i < 42; i++) {
        sObj = $("#SD" + i)[0];

        lObj = $("#LD" + i)[0];
        
        sObj.className = '';
        
        //在这里回显回来的数值，如果是工作日为淡粉红，假日为青色
        
        sD = i - cld.firstWeek;
        
        var type =  $("#GD" + i).attr("class") //每次进来 都清除所有样式
		$("#GD" + i).removeClass(type);
        if (sD > -1 && sD < cld.length) {  //日期内
            sObj.innerHTML = sD + 1;
			
			var nowDays = SY+''+addZ((SM+1))+addZ((sD+1));
			var hstr = hDays.join();
			if(hstr.indexOf(nowDays)>-1){
				 $("#GD" + i).addClass("selday");
			}
			sObj.style.color = cld[sD].color;  //国定假日颜色
			
            if (rows && rows.length > 0) {   //将从数据库查询到的数据回显。
	            for (var j = 0; j < rows.length; j++) {
	                var ob = rows[j];
	                if(ob.ymd == nowDays){
	                	if (ob.is_work_day == "1"){  //特殊工作日
	                		 $("#GD" + i).addClass("workday");
	                	}
						else if(ob.is_work_day == "0"){ //假日
							 $("#GD" + i).addClass("holiday");
						}
	                }
	            }
            }
            
            if (cld[sD].lDay == 1){  //显示农历月
                lObj.innerHTML = '<b>' + (cld[sD].isLeap ? '闰' : '') + cld[sD].lMonth + '月' + (monthDays(cld[sD].lYear, cld[sD].lMonth) == 29 ? '小' : '大') + '</b>';
            }else{  //显示农历日
                lObj.innerHTML = cDay(cld[sD].lDay);
            }
            
            s = cld[sD].lunarFestival;
           
            if (s.length > 0) {  //农历节日
                if (s.length > 8) s = s.substr(0, 7) + '...';
                	s = s.fontcolor('red');
                
            } else {  //国历节日
                s = cld[sD].solarFestival;
                if (s.length > 0) {
                    
                    s = (s == '黑色星期五') ? s.fontcolor('black') : s.fontcolor('#0066FF');
                }
                else {  //廿四节气
                    s = cld[sD].solarTerms;
                    if (s.length > 0)  s = s.fontcolor('limegreen');
                }
            }
            if (cld[sD].solarTerms == '清明') s = '清明节'.fontcolor('red');
            if (cld[sD].solarTerms == '芒种') s = '芒种'.fontcolor('red');
            if (cld[sD].solarTerms == '夏至') s = '夏至'.fontcolor('red');
            if (cld[sD].solarTerms == '冬至') s = '冬至'.fontcolor('red');

            if (s.length > 0) { lObj.innerHTML = s;}
            
            // 注册点击事件
			$("#GD" + i).unbind('click').click(function(){mOck(this,sD + 1,i);});
        }
        else {  //非日期
            $("#GD" + i).addClass("unover");
        }
    }
}


/*清除数据*/
function clear() {
    for (i = 0; i < 42; i++) {
        sObj = $("#SD" + i)[0];
        sObj.innerHTML = '';
        lObj = $("#LD" + i)[0];
        lObj.innerHTML = '';
        $("#GD" + i).removeClass("unover");
        $("#GD" + i).removeClass("jinri");
        $("#GD" + i).removeClass("selday");

    }

}


var Today = new Date();
var tY = Today.getFullYear();
var tM = Today.getMonth();

var tD = Today.getDate();
//////////////////////////////////////////////////////////////////////////////

var width = "130";
var offsetX = 2;
var offsetY = 18;

var x = 0;
var y = 0;
var snow = 0;
var sw = 0;
var cnt = 0;
var dStyle;


// 将农历iLunarMonth月格式化成农历表示的字符串
function FormatLunarMonth(iLunarMonth) {
    var szText = new String("正二三四五六七八九十");
    var strMonth;
    if (iLunarMonth <= 10) {
        strMonth = szText.substr(iLunarMonth - 1, 1);
    }
    else if (iLunarMonth == 11) strMonth = "十一";
    else strMonth = "十二";
    return strMonth + "月";
}
// 将农历iLunarDay日格式化成农历表示的字符串
function FormatLunarDay(iLunarDay) {
    var szText1 = new String("初十廿三");
    var szText2 = new String("一二三四五六七八九十");
    var strDay;
    if ((iLunarDay != 20) && (iLunarDay != 30)) {
        strDay = szText1.substr((iLunarDay - 1) / 10, 1) + szText2.substr((iLunarDay - 1) % 10, 1);
    }
    else if (iLunarDay != 20) {
        strDay = szText1.substr(iLunarDay / 10, 1) + "十";
    }
    else {
        strDay = "二十";
    }
    return strDay;
}
//显示详细日期资料
function mOvr(thisObj, v) {
    var s,festival,jy;

    sObj = $("#SD" + v);
    var d = sObj.html() - 1;

    if (sObj.html() != '') {
        if (cld[d].sgz5 != 0) {

            jy = cld[d].sgz5;
        } else {
            jy = jcr(cld[d].sgz3);

        }

        var arr = [];
        if (cld[d].solarTerms == '' && cld[d].solarFestival == '' && cld[d].lunarFestival == '')

            arr.push('<div id="teshu"></div>');
        else
        arr.push('<div id="teshu"><FONT  COLOR="#ff0000"  STYLE="font-size:12px;">' + cld[d].solarTerms + ' ' + cld[d].solarFestival + ' ' + cld[d].lunarFestival + '</FONT></div>');

        arr.push('<div style="width:65px; height:30px; color:#666666; float:left; font-size:60px; text-align:center;">' + cld[d].sDay + '</div>');
        arr.push('<font color="black" style="font-weight:bold;font-size:13px;">    ' + cld[d].sYear + '年' + cld[d].sMonth + '月' + cld[d].sDay + '日</font>');
        arr.push('<font style="font-size:12px;line-height:28px"><b>' + '星期' + cld[d].week + '</b></font><br>');
        arr.push('<font style="font-size:12px;color:#000000;" >农历' + (cld[d].isLeap ? '闰' : ' ') + FormatLunarMonth(cld[d].lMonth) + FormatLunarDay(cld[d].lDay) + '</font>');
        arr.push('<font style="font-size:12px">&nbsp;&nbsp;' + cld[d].cYear + '年 ' + cld[d].cMonth + '月 ' + cld[d].cDay + '日</font><br><br>');
        arr.push('<div style="width:95%; height:70px; margin-top:30px; padding-top:8px; border-top:1px solid #CCCCCC; margin-left:auto; margin-right:auto;">' + jy + '</div>');

        //thisObj.style.backgroundColor = '#fbfbad';
        var d = $(thisObj);
        var pos = d.offset();
        var t = pos.top + d.height() + 5; // 弹出框的上边位置
        var l = pos.left + d.width() - 150;  // 弹出框的左边位置


        //<!--

        var winWidth = 0;

        var winHeight = 0;

        function findDimensions() {

            // 获取窗口宽度

            if (window.innerWidth)

                winWidth = window.innerWidth;

            else if ((document.body) && (document.body.clientWidth))

                winWidth = document.body.clientWidth;

            // 获取窗口高度

            if (window.innerHeight)

                winHeight = window.innerHeight;

            else if ((document.body) && (document.body.clientHeight))

                winHeight = document.body.clientHeight;

            // 通过深入 Document 内部对 body 进行检测，获取窗口大小

            if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) {

                winHeight = document.documentElement.clientHeight;

                winWidth = document.documentElement.clientWidth;

            }

            // 结果输出至两个文本框


        }

        findDimensions();

        // 调用函数，获取数值

        window.onresize = findDimensions;

        //-->

        if (winHeight - pos.top < 230) {
            t = pos.top + d.height() - 180;
            l = pos.left + d.width() + 5;

        }

        if (winWidth - pos.left < 350) {

            t = pos.top + d.height() - 180;
            l = pos.left + d.width() - 360;

            if (pos.top < 216) {
                t = pos.top + d.height() - 100;
                l = pos.left + d.width() - 360;
            }
        }


        $("#details").addClass("pop");
        $("#details").css({ "top": t, "left": l }).show();
        $("#details").html(arr.join(""));


        if (snow == 0) {

            snow = 1;

        }


    }
}
//日期点击函数
function mOck(thisObj, v,i){
	var onoff = thisObj.attributes["on"].value; //判定当前是否已经选中了，0是表示之前没有被选 现在被选， 1是表示之前已经被选择了 现在取消
	var type = thisObj.getAttribute("class");  //判定类型 是否是特殊工作日和假日
	var dayContainer = thisObj.getElementsByTagName("font")[0]; //公历显示数据
	var nian = $('#nian').text();
	var yue = $('#yue').text();
	var dayJson = ""; //添加的数据
	var day = dayContainer.innerHTML;
	var ymd = nian+addZ(yue)+addZ(day);
	if (ymd.length!=8) {
		return false;
	}
	var dayContainer2 = thisObj.getElementsByTagName("font")[1];
	var name = dayContainer2.innerHTML;
	if (name.indexOf("font") > 0) { //获取农历的值
		var names = name.split(">");
		var namew = names[1].split("<");
		name = namew[0];
	}
	var ids = thisObj.attributes["id"].value
	
	//记录是否为周末        lx = 1  是工作日   0是周六 周末 和节假日  默认的
	//type =workday 特殊工作日    holiday 特殊假日
	var lx='1';//是工作日
	
	
	var dayColor = dayContainer.attributes["color"];
	var dayF = nian+'/'+addZ(yue)+'/'+addZ(day);
	if(dayColor&&dayColor.value=='red'&&getH(dayF)){
		 lx = '0';//周末
	}
	dayJson = '{ymd:'+nian+addZ(yue)+addZ(day)+',name:'+name+',isWorkDay:';
	
	//isworkday  0 为特殊假日  1 为特殊工作日
    //var sssss=document.getElementById(ymd).value;<img id='imgchlik' src='../img/false.png'/>加×号的
	if (type=="workday" || type=="seldaywork") {  //特殊工作日
		if (onoff == "0") {
			dayJson += '0}';//添加修改数据
			thisObj.attributes["on"].value='1';
			document.getElementById("setholiday").innerHTML += "<span class='date' id="+ymd+">"+ymd+"   "+"<img id='imgclick' value='"+ymd+"' onClick='imgonclick("+ymd+","+ids+","+lx+")' src='../../../static/calendar_redpanda/images/false.png'/></span>";//将内容加入框中
			thisObj.setAttribute("class", "seldaywork");//设定为选中样式
			
			hDays.push(dayJson);//加入数组
		}else if (onoff == "1"){
			dayJson += '0}';//添加修改数据
			thisObj.attributes["on"].value='0';
			thisObj.setAttribute("class","workday");//还原样式
			$("#ymd").remove();
			delArry(hDays,dayJson); //删除数据内容
			if(document.getElementById(ymd)){
				$("#"+ymd).remove();
			}
			delArry(hDays,dayJson); //删除数据内容
		}
	} else if(type == "holiday" || type=="seldayholiday"){ //特殊假日
		if (onoff == "0") {
			dayJson += '1}';//添加修改数据
			thisObj.attributes["on"].value='1';
			document.getElementById("setworkday").innerHTML += "<span  class='date' id="+ymd+">"+ymd+"   "+"<img id='imgclick' value='"+ymd+"' onClick='imgonclick("+ymd+","+ids+","+lx+")' src='../../../static/calendar_redpanda/images/false.png'/></span>";//将内容加入框中
			thisObj.setAttribute("class", "seldayholiday");//设定为选中样式
			hDays.push(dayJson);//加入数组
		}else if (onoff == "1"){
			dayJson += '1}';//添加修改数据
			thisObj.attributes["on"].value='0';
			thisObj.setAttribute("class", "holiday");//还原样式
			delArry(hDays,dayJson); //删除数据内容
			if(document.getElementById(ymd)){
				$("#"+ymd).remove();
			}
			delArry(hDays,dayJson); //删除数据内容
		}
	} else {
		if(lx =="1"){ //表示工作日 周一到周5 
			dayJson += '0}';//添加修改数据
		}else if (lx =="0") {
			dayJson += '1}';//添加修改数据
		}
		if (onoff == "0") {
			thisObj.attributes["on"].value='1'; 
			if(lx =="1"){ //表示工作日 周一到周5 
				document.getElementById("setholiday").innerHTML += "<span  class='date' id="+ymd+">"+ymd+"   "+"<img id='imgclick' value='"+ymd+"' onClick='imgonclick("+ymd+","+ids+","+lx+")' src='../../../static/calendar_redpanda/images/false.png'/></span>";//将内容加入框中
			}else if (lx =="0") {
				document.getElementById("setworkday").innerHTML += "<span  class='date' id="+ymd+">"+ymd+"   "+"<img id='imgclick' value='"+ymd+"' onClick='imgonclick("+ymd+","+ids+","+lx+")' src='../../../static/calendar_redpanda/images/false.png'/></span>";//将内容加入框中
			}
			hDays.push(dayJson);//加入数组
			thisObj.setAttribute("class", "selday");//设定为选中样式
		}else if (onoff == "1"){
			thisObj.attributes["on"].value='0';
			if(document.getElementById(ymd)){
				$("#"+ymd).remove();
			}
			//.innerHTML = "";//删除显示框中内容
			thisObj.setAttribute("class", "");//还原样式
			delArry(hDays,dayJson); //删除数据内容
		}
	}
}
/**
 * 图片点击X事件
 */
function imgonclick(value,ids,lx){
	var ss = ids.attributes["on"].value;
	var type = ids.getAttribute("class");  //判定类型 是否是特殊工作日和假日
	ids.attributes["on"].value='0'; //还原on的值
	var dayContainer2 = ids.getElementsByTagName("font")[1];
	var name = dayContainer2.innerHTML;
	if (name.indexOf("font") > 0) { //获取农历的值
		var names = name.split(">");
		var namew = names[1].split("<");
		name = namew[0];
	}
	var dayJsons = '{ymd:'+value+',name:'+name+',isWorkDay:';
	
	//还原样式 设置on的值
	if(type=="seldaywork"){
		dayJsons += '0}';//添加修改数据
		ids.setAttribute("class", "workday");
	}else if (type=="seldayholiday"){
		dayJsons += '1}';//添加修改数据
		ids.setAttribute("class", "holiday");
	}else if (type=="selday"){
		ids.setAttribute("class", "");
		if(lx =="1"){ //表示工作日 周一到周5 
			dayJsons += '0}';//添加修改数据
		}else if (lx =="0") {
			dayJsons += '1}';//添加修改数据
		}
	}
	//清除数据数组  
	delArry(hDays,dayJsons); //删除数据内容
	//清除文本框
	$("#"+value).remove();
}
//删除数组指定元素
function delArry(arr,obj){
	for (var i = arr.length - 1; i > -1; i--) { 
        if (arr[i] == obj) { 
            arr.splice(i, 1);//参数（删除的元素下标，从该下标起删除几个元素）
       }
      }
}
//去重数组
function delMoreArry(){
	var newArray = [],
      temp = {};
  for(var i = 0; i < this.length; i++){
           temp[typeof(this[i])+this[i]] = this[i];
      }
  for(var j in temp){
           newArray.push(temp[j]);
     }
 return newArray;
}
function addZ(obj){
	 return obj<10?'0'+obj:obj;
	}
function getH(obj){
	 var d = new Date(Date.parse(obj));
	 var c=d.getDay();
	 if(c==0||c==6){
	 	 return true;
	 	}else{
	 	return false;	
	 	}
	 //switch(c){    case 0:        a='星期日';        break;    case 1:        a='星期一';        break;    case 2:        a='星期二';        break;    case 3:        a='星期三';    case 4:        a='星期四';    case 5:        a='星期五';    case 6:        a='星期六';}
	}
//清除详细日期资料
function mOut(thisObj) {

 //   thisObj.style.backgroundColor = '';
    if (cnt >= 1) {
        sw = 0
    }
    if (sw == 0) {
        snow = 0;
        document.getElementById("details").style.display = 'none';
    }
    else  cnt++;
}


/*初始化日期*/

$(function() {
    initRiliIndex();
    clear();
    $("#nian").html(tY);
    $("#yue").html(tM + 1);

    /*年份递减*/
    $("#nianjian").click(function() {
        dateSelection.goPrevYear();

    });
    /*年份递加*/
    $("#nianjia").click(function() {
        dateSelection.goNextYear();

    });

    /*月份递减*/
    $("#yuejian").click(function() {
        dateSelection.goPrevMonth();
        $('.holiday').show();
    });
    

    
    /*月份递加*/
    $("#yuejia").click(function() {
        dateSelection.goNextMonth();

    });
    drawCld(tY, tM);

});


var global = {
    currYear : -1, // 当前年
    currMonth : -1, // 当前月，0-11
    currDate : null, // 当前点选的日期
    uid : null,
    username : null,
    email : null,
    single : false
    // 是否为独立页调用，如果是值为日历id，使用时请注意对0的判断，使用 single !== false 或者 single === false
};

var dateSelection = {
    currYear : -1,
    currMonth : -1,

    minYear : 1901,
    maxYear : 2200,

    beginYear : 0,
    endYear : 0,

    tmpYear : -1,
    tmpMonth : -1,

    init : function(year, month) {
        if (typeof year == 'undefined' || typeof month == 'undefined') {
            year = global.currYear;
            month = global.currMonth;
        }
        this.setYear(year);
        this.setMonth(month);
        this.showYearContent();
        this.showMonthContent();
    },
    show : function() {
        document.getElementById('dateSelectionDiv').style.display = 'block';
    },
    hide : function() {
        this.rollback();
        document.getElementById('dateSelectionDiv').style.display = 'none';
    },
    today : function() {
        var today = new Date();
        var year = today.getFullYear();
        var month = today.getMonth();

        if (this.currYear != year || this.currMonth != month) {
            if (this.tmpYear == year && this.tmpMonth == month) {
                this.rollback();
            } else {
                this.init(year, month);
                this.commit();
            }
        }
    },
    go : function() {
        if (this.currYear == this.tmpYear && this.currMonth == this.tmpMonth) {
            this.rollback();
        } else {
            this.commit();
        }
        this.hide();
    },
    goToday : function() {
        this.today();
        this.hide();
    },
    goPrevMonth : function() {
        this.prevMonth();
        this.commit();
    },
    goNextMonth : function() {
        this.nextMonth();
        this.commit();
    },
    goPrevYear : function() {
        this.prevYear();
        this.commit();
    },
    goNextYear : function() {
        this.nextYear();
        this.commit();
    },
    changeView : function() {
        global.currYear = this.currYear;
        global.currMonth = this.currMonth;
        clear();
        $("#nian").html(global.currYear);
        $("#yue").html(parseInt(global.currMonth) + 1);
        drawCld(global.currYear, global.currMonth);


    },
    commit : function() {
        if (this.tmpYear != -1 || this.tmpMonth != -1) {
            // 如果发生了变化
            if (this.currYear != this.tmpYear
                    || this.currMonth != this.tmpMonth) {
                // 执行某操作
                this.showYearContent();
                this.showMonthContent();
                this.changeView();


            }

            this.tmpYear = -1;
            this.tmpMonth = -1;
        }
    },
    rollback : function() {
        if (this.tmpYear != -1) {
            this.setYear(this.tmpYear);
        }
        if (this.tmpMonth != -1) {
            this.setMonth(this.tmpMonth);
        }
        this.tmpYear = -1;
        this.tmpMonth = -1;
        this.showYearContent();
        this.showMonthContent();
    },
    prevMonth : function() {
        var month = this.currMonth - 1;
        if (month == -1) {
            var year = this.currYear - 1;
            if (year >= this.minYear) {
                month = 11;
                this.setYear(year);
            } else {
                month = 0;
            }
        }
        this.setMonth(month);
    },
    nextMonth : function() {
        var month = this.currMonth + 1;
        if (month == 12) {
            var year = this.currYear + 1;
            if (year <= this.maxYear) {
                month = 0;
                this.setYear(year);
            } else {
                month = 11;
            }
        }
        this.setMonth(month);
    },
    prevYear : function() {
        var year = this.currYear - 1;
        if (year >= this.minYear) {
            this.setYear(year);
        }
    },
    nextYear : function() {
        var year = this.currYear + 1;
        if (year <= this.maxYear) {
            this.setYear(year);
        }
    },
    prevYearPage : function() {
        this.endYear = this.beginYear - 1;
        this.showYearContent(null, this.endYear);
    },
    nextYearPage : function() {
        this.beginYear = this.endYear + 1;
        this.showYearContent(this.beginYear, null);
    },
    selectYear : function() {//杨：select
        var selectY = $('select[@name="SY"] option[@selected]').text();
        this.setYear(selectY);
        this.commit();
    },
    selectMonth : function() {
        var selectM = $('select[@name="SM"] option[@selected]').text();
        this.setMonth(selectM - 1);
        this.commit();
    },
    setYear : function(value) {
        if (this.tmpYear == -1 && this.currYear != -1) {
            this.tmpYear = this.currYear;
        }
        $('#SY' + this.currYear).removeClass('curr');
        this.currYear = value;
        $('#SY' + this.currYear).addClass('curr');
    },
    setMonth : function(value) {
        if (this.tmpMonth == -1 && this.currMonth != -1) {
            this.tmpMonth = this.currMonth;
        }
        $('#SM' + this.currMonth).removeClass('curr');
        this.currMonth = value;
        $('#SM' + this.currMonth).addClass('curr');
    },
    showYearContent : function(beginYear, endYear) {
        if (!beginYear) {
            if (!endYear) {
                endYear = this.currYear + 1;
            }
            this.endYear = endYear;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
            }
            this.beginYear = this.endYear - 3;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
                this.endYear = this.beginYear + 3;
            }
        }
        if (!endYear) {
            if (!beginYear) {
                beginYear = this.currYear - 2;
            }
            this.beginYear = beginYear;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
            }
            this.endYear = this.beginYear + 3;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
                this.beginYear = this.endYear - 3;
            }
        }

        var s = '';
        for (var i = this.beginYear; i <= this.endYear; i++) {
            s += '<span id="SY' + i
                    + '" class="year" onclick="dateSelection.setYear(' + i
                    + ')">' + i + '</span>';
        }
        document.getElementById('yearListContent').innerHTML = s;
        $('#SY' + this.currYear).addClass('curr');
    },
    showMonthContent : function() {
        var s = '';
        for (var i = 0; i < 12; i++) {
            s += '<span id="SM' + i
                    + '" class="month" onclick="dateSelection.setMonth(' + i
                    + ')">' + (i + 1).toString() + '</span>';
        }
        document.getElementById('monthListContent').innerHTML = s;
        $('#SM' + this.currMonth).addClass('curr');
    },
    //根据节假日去相关的月份
	 goHoliday : function(N){
		this.setMonth(N);
		this.commit();
	}
};
function initRiliIndex() {
    var dateObj = new Date();
    global.currYear = dateObj.getFullYear();
    global.currMonth = dateObj.getMonth();

    dateSelection.init();

}