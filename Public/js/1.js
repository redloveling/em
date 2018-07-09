/**
 * Created by Red on 2017/3/31.
 */
(function () {
    var bd = NEJ.P, cg = NEJ.O, gm = NEJ.R, bb = bd("nej.e"), bj = bd("nej.v"), bM = bd("nej.ut"), zA;
    if (!!bM.cnc)return;
    bM.cnc = NEJ.C();
    zA = bM.cnc.bU(bM.dZ);
    zA.dv = function () {
        this.ko = {onchange: this.xm.bi(this), ondragend: this.xm.gY(this, !0)};
        this.dC()
    };
    zA.cz = function (bf) {
        this.cB(bf);
        this.ko.view = bb.bG(bf.track);
        this.ko.body = bb.bG(bf.slide);
        this.ko.mbar = this.ko.view;
        this.tg(bf.range);
        this.dq([[this.ko.view, "mousedown", this.bCZ.bi(this)]]);
        this.lA = bM.zm.bF(this.ko)
    };
    zA.cR = function () {
        this.cV();
        this.lA.bW();
        delete this.lA;
        delete this.hL;
        delete this.ko.view;
        delete this.ko.body;
        delete this.ko.mbar
    };
    zA.xm = function (be, kp) {
        var bjO = be.left / this.hL.x[1], bjN = be.top / this.hL.y[1], bjJ = this.hL.x, bjI = this.hL.y;
        this.bK("onchange", {
            stopped: !!kp,
            x: {rate: bjO, value: bjO * (bjJ[1] - bjJ[0])},
            y: {rate: bjN, value: bjN * (bjI[1] - bjI[0])}
        })
    };
    zA.bCZ = function (be) {
        var cq = bb.jX(this.ko.view), bnF = {
            x: bj.mS(be),
            y: bj.qi(be)
        }, cjL = {x: Math.floor(this.ko.body.offsetWidth / 2), y: Math.floor(this.ko.body.offsetHeight / 2)};
        this.lA.hn({top: bnF.y - cq.y - cjL.y, left: bnF.x - cq.x - cjL.x})
    };
    zA.tg = function (dQ) {
        var qk;
        if (!!this.hL) {
            var ld = this.lA.bdj();
            qk = {x: ld.left / this.hL.x[1], y: ld.top / this.hL.y[1]}
        }
        dQ = dQ || cg;
        var bCW = (dQ.x || gm)[1] || this.ko.view.clientWidth - this.ko.body.offsetWidth, bCX = (dQ.y || gm)[1] || this.ko.view.clientHeight - this.ko.body.offsetHeight;
        this.hL = {x: dQ.x || [0, bCW], y: dQ.y || [0, bCX]};
        if (!!qk) this.hn(qk);
        return this
    };
    zA.hn = function (qk) {
        qk = qk || cg;
        this.lA.hn({top: this.hL.y[1] * (qk.y || 0), left: this.hL.x[1] * (qk.x || 0)})
    }
})();
(function () {
    var bM = NEJ.P("nej.ut"), bjM;
    if (!!bM.EP)return;
    bM.EP = NEJ.C();
    bjM = bM.EP.bU(bM.cnc);
    bjM.dv = function () {
        this.dC();
        this.ko.direction = 2
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bM = bd("nej.p"), di = bd("nej.ui"), fc = bd("nej.ut"), bT = bd("nm.w"), bc, bO;
    bT.ww = NEJ.C();
    bc = bT.ww.bU(di.gh);
    bO = bT.ww.dr;
    bc.dv = function () {
        this.dC()
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.bs = bb.bG(bf.content);
        this.lD = bb.bG(bf.slide);
        this.jw = bb.bG(bf.track);
        this.bli = bf.speed;
        this.bhd = this.bs.scrollHeight - this.bs.clientHeight;
        bb.ch(this.lD, "height", (this.bs.clientHeight / this.bs.scrollHeight * parseInt(bb.ey(this.jw, "height")) || 0) + "px");
        if (this.bs.scrollHeight <= this.bs.clientHeight) bb.ch(this.lD, "display", "none"); else bb.ch(this.lD, "display", "block");
        this.tq = fc.EP.bF({slide: this.lD, track: this.jw, onchange: this.bgX.bi(this)});
        if (bM.ek.browser != "firefox") this.dq([[this.bs, "mousewheel", this.AP.bi(this)]]); else {
            this.bs.addEventListener("DOMMouseScroll", this.AP.bi(this), false)
        }
    };
    bc.cR = function () {
        this.cV();
        this.tq.bW();
        delete this.bs;
        delete this.lD;
        delete this.jw;
        delete this.hL;
        delete this.bli
    };
    bc.bgX = function (be) {
        this.bs.scrollTop = parseInt(this.bhd * be.y.rate)
    };
    bc.AP = function (be) {
        bj.dp(be);
        this.bhd = this.bs.scrollHeight - this.bs.clientHeight;
        var cjL = 0, DF, en, hs;
        en = parseInt(this.jw.clientHeight) - parseInt(bb.ey(this.lD, "height"));
        cjL = be.wheelDelta ? be.wheelDelta / 120 : -be.detail / 3;
        DF = parseInt(bb.ey(this.lD, "top")) - cjL * this.bli;
        if (DF < 0) DF = 0;
        if (DF > en) DF = en;
        bb.ch(this.lD, "top", DF + "px");
        hs = parseInt(bb.ey(this.lD, "top"));
        this.tq.bK("onchange", {y: {rate: hs / en}})
    };
    bc.os = function () {
        this.bhd = this.bs.scrollHeight - this.bs.clientHeight;
        this.tq.hn({x: 0, y: 0});
        bb.ch(this.lD, "height", this.bs.clientHeight / this.bs.scrollHeight * parseInt(this.jw.clientHeight) + "px");
        this.tq.tg({x: [], y: [0, this.jw.clientHeight - parseInt(bb.ey(this.lD, "height"))]});
        if (this.bs.scrollHeight <= this.bs.clientHeight) bb.ch(this.lD, "display", "none"); else bb.ch(this.lD, "display", "block")
    };
    bc.hn = function (hl) {
        this.tq.hn(hl)
    };
    bc.DG = function (bgT) {
        var bRm = parseInt(bb.ey(this.lD, "height"));
        var bRs = parseInt(bb.ey(this.jw, "height"));
        var us = bRs - bRm;
        var hs = parseInt(us * bgT) + "px";
        bb.ch(this.lD, "top", hs)
    };
    bc.blu = function () {
        if (this.bs.scrollHeight <= this.bs.clientHeight)return;
        var bgT = this.bs.scrollTop / (this.bs.scrollHeight - this.bs.clientHeight);
        this.DG(bgT)
    };
    bc.ces = function () {
        if (this.tq) this.tq.tg()
    }
})();
(function () {
    var p = NEJ.P("nej.u");
    var mH = 8;
    var Qn = function (gk, dE) {
        return gk << dE | gk >>> 32 - dE
    };
    var lH = function (x, y) {
        var bwx = (x & 65535) + (y & 65535), bLt = (x >> 16) + (y >> 16) + (bwx >> 16);
        return bLt << 16 | bwx & 65535
    };
    var bLu = function (t, b, c, d) {
        if (t < 20)return b & c | ~b & d;
        if (t < 40)return b ^ c ^ d;
        if (t < 60)return b & c | b & d | c & d;
        return b ^ c ^ d
    };
    var bLv = function (t) {
        if (t < 20)return 1518500249;
        if (t < 40)return 1859775393;
        if (t < 60)return -1894007588;
        return -899497514
    };
    var sU = function () {
        var zW = function (i) {
            return i % 32
        }, zV  = function (i) {
            return 32 - mH - i % 32
        };
        return function (dT, zT) {
            var JG = [], kD = (1 << mH) - 1, nD = zT ? zW : zV;
            for (var i = 0, l = dT.length * mH; i < l; i += mH)JG[i >> 5] |= (dT.charCodeAt(i / mH) & kD) << nD(i);
            return JG
        }
    }();
    var JI = function () {
        var bws = "0123456789abcdef", zW = function (i) {
            return i % 4
        }, zV   = function (i) {
            return 3 - i % 4
        };
        return function (jA, zT) {
            var cH = [], nD = zT ? zW : zV;
            for (var i = 0, l = jA.length * 4; i < l; i++) {
                cH.push(bws.charAt(jA[i >> 2] >> nD(i) * 8 + 4 & 15) + bws.charAt(jA[i >> 2] >> nD(i) * 8 & 15))
            }
            return cH.join("")
        }
    }();
    var Qe = function () {
        var zW = function (i) {
            return i % 32
        }, zV  = function (i) {
            return 32 - mH - i % 32
        };
        return function (JG, zT) {
            var cH = [], kD = (1 << mH) - 1, nD = zT ? zW : zV;
            for (var i = 0, l = JG.length * 32; i < l; i += mH)cH.push(String.fromCharCode(JG[i >> 5] >>> nD(i) & kD));
            return cH.join("")
        }
    }();
    var GI = function () {
        var bLw = "=", bLy = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", zW = function (i) {
            return i % 4
        }, zV   = function (i) {
            return 3 - i % 4
        };
        return function (jA, zT) {
            var cH = [], nD = zT ? zW : zV;
            for (var i = 0, bwo; i < jA.length * 4; i += 3) {
                bwo = (jA[i >> 2] >> 8 * nD(i) & 255) << 16 | (jA[i + 1 >> 2] >> 8 * nD(i + 1) & 255) << 8 | jA[i + 2 >> 2] >> 8 * nD(i + 2) & 255;
                for (var j = 0; j < 4; j++)cH.push(i * 8 + j * 6 > jA.length * 32 ? bLw : bLy.charAt(bwo >> 6 * (3 - j) & 63))
            }
            return cH.join("")
        }
    }();
    var Qd = function (q, a, b, x, s, t) {
        return lH(Qn(lH(lH(a, q), lH(x, t)), s), b)
    };
    var nG = function (a, b, c, d, x, s, t) {
        return Qd(b & c | ~b & d, a, b, x, s, t)
    };
    var nH = function (a, b, c, d, x, s, t) {
        return Qd(b & d | c & ~d, a, b, x, s, t)
    };
    var nI = function (a, b, c, d, x, s, t) {
        return Qd(b ^ c ^ d, a, b, x, s, t)
    };
    var nK = function (a, b, c, d, x, s, t) {
        return Qd(c ^ (b | ~d), a, b, x, s, t)
    };
    var Fx = function (x, y) {
        x[y >> 5] |= 128 << y % 32;
        x[(y + 64 >>> 9 << 4) + 14] = y;
        var a = 1732584193, b = -271733879, c = -1732584194, d = 271733878;
        for (var i = 0, l = x.length, bwn, bwl, bwk, bwj; i < l; i += 16) {
            bwn = a;
            bwl = b;
            bwk = c;
            bwj = d;
            a = nG(a, b, c, d, x[i + 0], 7, -680876936);
            d = nG(d, a, b, c, x[i + 1], 12, -389564586);
            c = nG(c, d, a, b, x[i + 2], 17, 606105819);
            b = nG(b, c, d, a, x[i + 3], 22, -1044525330);
            a = nG(a, b, c, d, x[i + 4], 7, -176418897);
            d = nG(d, a, b, c, x[i + 5], 12, 1200080426);
            c = nG(c, d, a, b, x[i + 6], 17, -1473231341);
            b = nG(b, c, d, a, x[i + 7], 22, -45705983);
            a = nG(a, b, c, d, x[i + 8], 7, 1770035416);
            d = nG(d, a, b, c, x[i + 9], 12, -1958414417);
            c = nG(c, d, a, b, x[i + 10], 17, -42063);
            b = nG(b, c, d, a, x[i + 11], 22, -1990404162);
            a = nG(a, b, c, d, x[i + 12], 7, 1804603682);
            d = nG(d, a, b, c, x[i + 13], 12, -40341101);
            c = nG(c, d, a, b, x[i + 14], 17, -1502002290);
            b = nG(b, c, d, a, x[i + 15], 22, 1236535329);
            a = nH(a, b, c, d, x[i + 1], 5, -165796510);
            d = nH(d, a, b, c, x[i + 6], 9, -1069501632);
            c = nH(c, d, a, b, x[i + 11], 14, 643717713);
            b = nH(b, c, d, a, x[i + 0], 20, -373897302);
            a = nH(a, b, c, d, x[i + 5], 5, -701558691);
            d = nH(d, a, b, c, x[i + 10], 9, 38016083);
            c = nH(c, d, a, b, x[i + 15], 14, -660478335);
            b = nH(b, c, d, a, x[i + 4], 20, -405537848);
            a = nH(a, b, c, d, x[i + 9], 5, 568446438);
            d = nH(d, a, b, c, x[i + 14], 9, -1019803690);
            c = nH(c, d, a, b, x[i + 3], 14, -187363961);
            b = nH(b, c, d, a, x[i + 8], 20, 1163531501);
            a = nH(a, b, c, d, x[i + 13], 5, -1444681467);
            d = nH(d, a, b, c, x[i + 2], 9, -51403784);
            c = nH(c, d, a, b, x[i + 7], 14, 1735328473);
            b = nH(b, c, d, a, x[i + 12], 20, -1926607734);
            a = nI(a, b, c, d, x[i + 5], 4, -378558);
            d = nI(d, a, b, c, x[i + 8], 11, -2022574463);
            c = nI(c, d, a, b, x[i + 11], 16, 1839030562);
            b = nI(b, c, d, a, x[i + 14], 23, -35309556);
            a = nI(a, b, c, d, x[i + 1], 4, -1530992060);
            d = nI(d, a, b, c, x[i + 4], 11, 1272893353);
            c = nI(c, d, a, b, x[i + 7], 16, -155497632);
            b = nI(b, c, d, a, x[i + 10], 23, -1094730640);
            a = nI(a, b, c, d, x[i + 13], 4, 681279174);
            d = nI(d, a, b, c, x[i + 0], 11, -358537222);
            c = nI(c, d, a, b, x[i + 3], 16, -722521979);
            b = nI(b, c, d, a, x[i + 6], 23, 76029189);
            a = nI(a, b, c, d, x[i + 9], 4, -640364487);
            d = nI(d, a, b, c, x[i + 12], 11, -421815835);
            c = nI(c, d, a, b, x[i + 15], 16, 530742520);
            b = nI(b, c, d, a, x[i + 2], 23, -995338651);
            a = nK(a, b, c, d, x[i + 0], 6, -198630844);
            d = nK(d, a, b, c, x[i + 7], 10, 1126891415);
            c = nK(c, d, a, b, x[i + 14], 15, -1416354905);
            b = nK(b, c, d, a, x[i + 5], 21, -57434055);
            a = nK(a, b, c, d, x[i + 12], 6, 1700485571);
            d = nK(d, a, b, c, x[i + 3], 10, -1894986606);
            c = nK(c, d, a, b, x[i + 10], 15, -1051523);
            b = nK(b, c, d, a, x[i + 1], 21, -2054922799);
            a = nK(a, b, c, d, x[i + 8], 6, 1873313359);
            d = nK(d, a, b, c, x[i + 15], 10, -30611744);
            c = nK(c, d, a, b, x[i + 6], 15, -1560198380);
            b = nK(b, c, d, a, x[i + 13], 21, 1309151649);
            a = nK(a, b, c, d, x[i + 4], 6, -145523070);
            d = nK(d, a, b, c, x[i + 11], 10, -1120210379);
            c = nK(c, d, a, b, x[i + 2], 15, 718787259);
            b = nK(b, c, d, a, x[i + 9], 21, -343485551);
            a = lH(a, bwn);
            b = lH(b, bwl);
            c = lH(c, bwk);
            d = lH(d, bwj)
        }
        return [a, b, c, d]
    };
    var biI = function (bN, bl) {
        var sG = sU(bN, !0);
        if (sG.length > 16) sG = Fx(sG, bN.length * mH);
        var JV = Array(16), JW = Array(16);
        for (var i = 0; i < 16; i++) {
            JV[i] = sG[i] ^ 909522486;
            JW[i] = sG[i] ^ 1549556828
        }
        var fA = Fx(JV.concat(sU(bl, !0)), 512 + bl.length * mH);
        return Fx(JW.concat(fA), 512 + 128)
    };
    var FB = function (x, cF) {
        x[cF >> 5] |= 128 << 24 - cF % 32;
        x[(cF + 64 >> 9 << 4) + 15] = cF;
        var w = Array(80), a = 1732584193, b = -271733879, c = -1732584194, d = 271733878, e = -1009589776;
        for (var i = 0, l = x.length, bwi, bwg, PD, bwe, bwd; i < l; i += 16) {
            bwi = a;
            bwg = b;
            PD = c;
            bwe = d;
            bwd = e;
            for (var j = 0; j < 80; j++) {
                w[j] = j < 16 ? x[i + j] : Qn(w[j - 3] ^ w[j - 8] ^ w[j - 14] ^ w[j - 16], 1);
                var t = lH(lH(Qn(a, 5), bLu(j, b, c, d)), lH(lH(e, w[j]), bLv(j)));
                e = d;
                d = c;
                c = Qn(b, 30);
                b = a;
                a = t
            }
            a = lH(a, bwi);
            b = lH(b, bwg);
            c = lH(c, PD);
            d = lH(d, bwe);
            e = lH(e, bwd)
        }
        return [a, b, c, d, e]
    };
    var biV = function (bN, bl) {
        var sG = sU(bN);
        if (sG.length > 16) sG = FB(sG, bN.length * mH);
        var JV = Array(16), JW = Array(16);
        for (var i = 0; i < 16; i++) {
            JV[i] = sG[i] ^ 909522486;
            JW[i] = sG[i] ^ 1549556828
        }
        var fA = FB(JV.concat(sU(bl)), 512 + bl.length * mH);
        return FB(JW.concat(fA), 512 + 160)
    };
    p.cfx = function (bN, bl) {
        return JI(biV(bN, bl))
    };
    p.cfw = function (bN, bl) {
        return GI(biV(bN, bl))
    };
    p.cfv = function (bN, bl) {
        return Qe(biV(bN, bl))
    };
    p.cft = function (bN, bl) {
        return JI(biI(bN, bl), !0)
    };
    p.cfr = function (bN, bl) {
        return GI(biI(bN, bl), !0)
    };
    p.cfp = function (bN, bl) {
        return Qe(biI(bN, bl), !0)
    };
    p.cfn = function (bl) {
        return JI(FB(sU(bl), bl.length * mH))
    };
    p.cfm = function (bl) {
        return GI(FB(sU(bl), bl.length * mH))
    };
    p.cfh = function (bl) {
        return Qe(FB(sU(bl), bl.length * mH))
    };
    p.lB = function (bl) {
        return JI(Fx(sU(bl, !0), bl.length * mH), !0)
    };
    p.cff = function (bl) {
        return GI(Fx(sU(bl, !0), bl.length * mH), !0)
    };
    p.cfe = function (bl) {
        return Qe(Fx(sU(bl, !0), bl.length * mH), !0)
    };
    p.cfd = function (bl) {
        return JI(sU(bl, !0), !0)
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bA = bd("nej.j"), cg = bd("nej.o"), bm = bd("nej.u"), bj = bd("nej.v"), di = bd("nej.ui"), bq = bd("nm.d"), bn = bd("nm.x"), bo = bd("nm.l"), bc, bO;
    bo.boU = NEJ.C();
    bc = bo.boU.bU(bo.fz, !0);
    bc.dv = function () {
        this.dC()
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.QI = bk[0];
        this.sX = bk[1];
        this.bdq = bk[2];
        bj.bt(bk[3], "click", this.bjp.bi(this))
    };
    bc.dx = function () {
        this.dy = "ntp-alert"
    };
    bc.cz = function (bf) {
        bf.parent = bf.parent || document.body;
        this.cB(bf);
        bb.ch(this.QI, "display", "");
        if (bf.type == "noicon") {
            bb.ch(this.QI, "display", "none")
        } else if (bf.type == "success") {
            bb.gL(this.QI, "u-icn-88", "u-icn-89")
        } else {
            bb.gL(this.QI, "u-icn-89", "u-icn-88")
        }
        this.sX.innerHTML = bf.mesg || "";
        if (bf.mesg2) {
            bb.bH(this.bdq, "f-hide");
            this.bdq.innerHTML = bf.mesg2 || ""
        } else {
            bb.bJ(this.bdq, "f-hide")
        }
    };
    bc.cR = function () {
        this.cV()
    };
    bc.bjp = function (be) {
        this.bK("onnotice");
        this.cw()
    };
    bo.gz = function (bf) {
        if (this.wn) {
            this.wn.bW();
            delete this.wn
        }
        this.wn = bo.boU.bF(bf);
        this.wn.bR()
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bj = bd("nej.v"), bm = bd("nej.u"), bI = bd("nej.ut"), bq = bd("nm.d"), bn = bd("nm.x"), bo = bd("nm.l"), bN = "RADIO_LATEST_MAP", bc, bO;
    bq.fX({
        "radio_crt-list": {
            url: "/api/djradio/get/byuser", format: function (bV, bf) {
                var bk = bV.djRadios;
                return {total: bk.length || 0, list: bk}
            }
        }, "radio_sub-list": {
            url: "/api/djradio/get/subed", format: function (bV, bf) {
                var bk = bV.djRadios;
                bf.data.time = bV.time;
                return {total: bV.count || 0, list: bk}
            }
        }, "radio_sub-add": {
            url: "/api/djradio/sub", filter: function (bf) {
                bf.data = {id: bf.id}
            }, format: function (bV, bf) {
                if (this.boQ("firstSub")) {
                    bo.gz({title: "订阅成功", type: "noicon", mesg: "可以在“我的音乐-我的电台”收到节目更新"})
                } else {
                    bo.ci.bR({tip: "订阅成功"})
                }
                var eC = this.fw(bf.id) || bf.ext.data;
                eC.subCount += 1;
                eC.subed = true;
                return eC
            }, finaly: function (be, bf) {
                bj.bK(bq.nz, "listchange", be);
                bj.bK(bq.nz, "itemchange", {attr: "subCount", data: be.data})
            }, onmessage: function (dX) {
                if (dX == 315) {
                    bo.ci.bR({tip: "根据对方设置，你没有该操作权限", type: 2})
                }
            }
        }, "radio_sub-del": {
            url: "/api/djradio/unsub", filter: function (bf) {
                bf.data = {id: bf.id}
            }, format: function (bV, bf) {
                bo.ci.bR({tip: "取消订阅成功"});
                var eC = this.fw(bf.id) || bf.ext.data;
                eC.subCount -= 1;
                eC.subed = false;
                return eC
            }, finaly: function (be, bf) {
                bj.bK(bq.nz, "listchange", be);
                bj.bK(bq.nz, "itemchange", {attr: "subCount", data: be.data})
            }
        }
    });
    bq.nz = NEJ.C();
    bc = bq.nz.bU(bq.ik);
    bc.bXD = function (dN, cT) {
        var cE = this.zP(bN, {});
        cE[dN.radio.id] = {id: dN.id, name: dN.name, time: cT || 0};
        this.uw(bN, cE)
    };
    bc.bXG = function (bB) {
        return this.zP(bN, {})[bB]
    };
    bc.boH = function (eC) {
        var dG = {key: "radio_sub", ext: {}};
        if (bm.qj(eC)) {
            dG.id = eC.id;
            dG.ext.data = eC
        } else {
            dG.id = eC
        }
        return dG
    };
    bc.lP = function (eC) {
        if (bn.ic()) this.kV(this.boH(eC))
    };
    bc.boG = function (eC) {
        bn.iu({
            btnok: "确定", btncc: "取消", message: "确定取消订阅？", action: function (bD) {
                if (bD == "ok") {
                    this.Mb(this.boH(eC))
                }
            }.bi(this)
        })
    };
    bc.boQ = function () {
        var cmE = "RADIO_UPGRADE_TIP";
        return function (bu) {
            var bl = this.zP(cmE, {});
            if (bl[bu]) {
                return false
            } else {
                bl[bu] = true;
                this.uw(cmE, bl);
                return true
            }
        }
    }();
    bI.gN.bF({element: bq.nz, event: ["listchange", "itemchange"]})
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bj = bd("nej.v"), bI = bd("nej.ut"), bm = bd("nej.u"), bA = bd("nej.j"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), bc;
    var QUEUE_KEY = "track-queue";
    var PlayMode = {SINGLE_CYCLE: 2, LIST_LOOP: 4, RANDOM: 5};
    bT.rJ = NEJ.C();
    bc = bT.rJ.bU(bI.dZ);
    bc.cz = function (bf) {
        this.cB(bf);
        this.cO = bT.hB.iE();
        this.jx = [];
        this.vQ = [];
        this.mn = bn.Xo();
        this.fG = 0;
        this.dq([[bT.hB, "playaction", this.ud.bi(this)]]);
        this.kt = bq.kQ.bF();
        this.sO = bq.nz.bF();
        this.bXW()
    };
    bc.cR = function () {
        this.cV();
        delete this.jx;
        delete this.vQ;
        delete this.mn
    };
    bc.QO = function () {
        bA.wl(QUEUE_KEY, this.jx)
    };
    bc.bXI = function () {
        var tk = [PlayMode.SINGLE_CYCLE, PlayMode.LIST_LOOP, PlayMode.RANDOM];
        return function () {
            var fC, bv = bm.eg(tk, this.mn.mode);
            fC = bv < 0 ? PlayMode.LIST_LOOP : tk[(bv + 1) % 3];
            this.mn.mode = fC;
            if (this.Ir()) {
                this.bdw()
            }
            bn.Dh(this.mn);
            return this.mn.mode
        }
    }();
    bc.bXH = function () {
        return this.mn.mode
    };
    bc.qC = function () {
        this.BJ(this.boK(+1), "ui")
    };
    bc.Dz = function () {
        this.BJ(this.boK(-1), "ui")
    };
    bc.qz = function () {
        return this.jx[this.fG]
    };
    bc.bXC = function (jl, qO, fQ) {
        if (!jl || !jl.length)return;
        var cE = {}, xp = jl[0];
        if (!qO) {
            bm.cv(this.jx, function (co) {
                cE[co.id] = co
            });
            bm.cv(jl, function (co) {
                if (cE[co.id]) {
                    if (xp.id == co.id) {
                        xp = cE[co.id]
                    }
                } else {
                    this.jx.push(co)
                }
            }, this)
        } else {
            this.jx = jl
        }
        if (this.Ir()) {
            this.bdw()
        }
        if (fQ) {
            this.BJ(bm.eg(this.jx, xp));
            this.cO.hj()
        }
        this.QO();
        bj.bK(bT.rJ, "queuechange", {cmd: fQ ? "play" : "addto"})
    };
    bc.mw = function (cmJ) {
        var bv = bm.eg(this.jx, function (co) {
            return co.id == cmJ
        });
        if (bv != -1) {
            var bXw = bv == this.fG && this.jx.length > 1, bXt = bv == this.jx.length - 1, co = this.jx[bv];
            this.jx.splice(bv, 1);
            if (this.Ir()) {
                this.vQ.splice(bm.eg(this.vQ, co), 1)
            }
            if (bXw) {
                if (bXt) {
                    this.BJ(bv - 1)
                } else {
                    this.BJ(bv)
                }
            } else if (bv < this.fG) {
                this.fG--
            }
            this.QO();
            bj.bK(bT.rJ, "queuechange", {cmd: "delete"})
        }
    };
    bc.yJ = function () {
        this.jx = [];
        this.vQ = [];
        this.mn.index = this.fG = 0;
        bn.Dh(this.mn);
        this.QO();
        bj.bK(bT.rJ, "queuechange", {cmd: "clear"})
    };
    bc.qz = function () {
        return this.jx[this.fG]
    };
    bc.boP = function () {
        return this.jx
    };
    bc.kW = function () {
        return this.jx.length
    };
    bc.bdr = function (bB) {
        var bv = bm.eg(this.jx, function (co) {
            return bB == co.id
        });
        if (bv >= 0) {
            return this.jx[bv]
        }
    };
    bc.bXq = function (bB) {
        var bv = bm.eg(this.jx, function (co) {
            return bB == co.id
        });
        if (bv >= 0) {
            this.BJ(bv);
            this.cO.hj()
        }
    };
    bc.bXW = function () {
        this.jx = bA.sj(QUEUE_KEY) || [];
        this.fG = this.mn.index || 0;
        if (this.jx.length && this.Ir()) {
            this.bdw()
        }
        this.cO.Un(this.qz())
    };
    bc.boK = function (cjL) {
        if (this.Ir()) {
            var hb = this.qz(), bv = inRange(bm.eg(this.vQ, hb) + cjL, this.vQ.length);
            return bm.eg(this.jx, this.vQ[bv])
        } else {
            return inRange(this.fG + cjL, this.jx.length)
        }
        function inRange(bv, cF) {
            return bv < 0 ? cF - 1 : bv >= cF ? 0 : bv
        }
    };
    bc.bdw = function () {
        var bk = this.jx.slice(0);
        this.vQ = [];
        while (bk.length) {
            var bv = bm.HQ(0, bk.length - 1);
            this.vQ.push(bk[bv]);
            bk.splice(bv, 1)
        }
    };
    bc.BJ = function (bv, bu) {
        if (!this.jx.length)return;
        var jO, lT = this.qz(), boS = this.cO.Yk();
        this.fG = bv;
        this.mn.index = this.fG;
        jO = this.jx[this.fG];
        bn.Dh(this.mn);
        bj.bK(bT.rJ, "playchange", {old: lT, "new": jO, type: bu});
        this.cO.Un(this.qz());
        if (lT && boS > 3) {
            this.kt.VC(lT.id, boS, lT.source, bu || "interrupt")
        }
        if (jO && jO.program) this.sO.bXD(jO.program, 0)
    };
    bc.Ir = function () {
        return this.mn.mode == PlayMode.RANDOM
    };
    bc.ud = function (be) {
        if (be.action == "ended") {
            if (this.mn.mode == PlayMode.SINGLE_CYCLE) {
                this.BJ(this.fG, "playend")
            } else {
                this.qC()
            }
        }
    };
    bI.gN.bF({element: bT.rJ, event: ["queuechange", "playchange"]})
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), ej = bd("nej.p"), bA = bd("nej.j"), cA = bd("nej.ui"), bI = bd("nej.ut"), bq = bd("nm.d"), bo = bd("nm.l"), bn = bd("nm.x"), eT = bd("nm.u"), bT = bd("nm.w"), bL = bd("nm.m.f"), bc, bO;
    bL.boT = NEJ.C();
    bc = bL.boT.bU(cA.gh);
    bc.dv = function () {
        this.dC();
        this.ho = bT.rJ.iE();
        bj.bt(bT.rJ, "queuechange", this.um.bi(this));
        bj.bt(bT.rJ, "playchange", this.iH.bi(this))
    };
    bc.dx = function () {
        this.dy = "m-player-panel"
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.QG = bk[0];
        this.kP = bk[1];
        this.IG = bk[2];
        this.cW = bk[3];
        this.IM = bk[4];
        this.iJ = bT.ww.bF({track: this.IM, slide: bb.eu(this.IM)[0], content: this.cW, speed: 4});
        this.dk = {nask: bk[5], nmenu: bk[6], nlist: bk[7], nscroll: bk[8]};
        bj.bt(this.bs, "click", this.cS.bi(this));
        bj.bt(this.IG, "load", this.vE.bi(this))
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.mR = bT.boZ.bF(this.dk);
        this.iH({"new": this.ho.qz()});
        this.iJ.os();
        var bk = bb.bP(this.cW, "z-sel");
        if (bk.length) {
            var cq = bb.jX(bk[0], this.cW);
            this.cW.scrollTop = this.cW.scrollTop + (cq.y - (this.cW.scrollTop + 112));
            this.iJ.blu()
        }
    };
    bc.cR = function () {
        this.bK("onclose");
        if (this.mR) {
            this.mR.bW();
            delete this.mR
        }
        this.cV()
    };
    bc.um = function (be) {
        bb.fR(this.cW, "m-player-queue", {queue: this.ho.boP(), current: this.ho.qz()}, {
            dur2time: bn.nJ,
            getArtistName: bn.ph
        });
        this.QG.innerText = this.ho.kW();
        if (be && be.cmd == "delete")return;
        var bk = bb.bP(this.cW, "z-sel");
        if (bk.length) {
            var cq = bb.jX(bk[0], this.cW);
            this.cW.scrollTop = Math.max(Math.min(cq.y, this.cW.scrollTop), cq.y - 224);
            this.iJ.blu()
        }
    };
    bc.cS = function (be) {
        var bh, bB, bpa;
        bh = bj.bY(be, "a:href");
        if (bh && bh.tagName.toLocaleLowerCase() == "a" && /^http/.test(bh.href)) {
            return
        }
        bj.ru(be);
        bh = bj.bY(be, "d:action");
        bB = bb.bz(bh, "id");
        switch (bb.bz(bh, "action")) {
            case"likeall":
                var jU = this.ho.boP();
                if (jU && jU.length) {
                    var bk = [];
                    bm.cv(jU, function (bw) {
                        if (!bw.program) bk.push(bw)
                    });
                    window.subscribe(bk, !1);
                    this.bW()
                }
                break;
            case"delete":
                this.ho.mw(bB);
                bj.cu(be);
                break;
            case"like":
                var co = this.ho.bdr(bB);
                window.subscribe(co, false);
                bj.cu(be);
                this.bW();
                break;
            case"share":
                co = this.ho.bdr(bB);
                !co.program ? bn.sd({
                        rid: co.id,
                        type: 18,
                        purl: co.album.picUrl,
                        name: co.name,
                        author: bn.vj(co.artists)
                    }) : bn.sd({
                        rid: co.program.id,
                        type: 17,
                        purl: co.program.coverUrl,
                        name: co.program.name,
                        author: (co.program.radio || []).name
                    });
                bj.cu(be);
                this.bW();
                break;
            case"download":
                co = this.ho.bdr(bB);
                if (co.program) {
                    bn.NW({type: 17, id: co.program.id})
                } else {
                    bpa = bn.oP(co);
                    if (bpa == 1e3) {
                        bn.kK("因版权方要求，该歌曲不支持下载")
                    } else {
                        bn.NW({type: 18, id: co.id})
                    }
                }
                this.bW();
                break;
            case"play":
                this.ho.bXq(bB);
                break;
            case"clear":
                this.ho.yJ();
                break;
            case"close":
                this.bW();
                break
        }
    };
    bc.iH = function (be) {
        var vH = be["new"];
        if (vH) {
            this.mR && this.mR.bXi(vH);
            if (vH.program) {
                this.IG.src = vH.program.blurCoverUrl;
                this.kP.innerText = vH.program.name
            } else {
                this.IG.src = "http://music.163.com/api/img/blur/" + (vH.album.pic_str || vH.album.pic || vH.album.picId_str || vH.album.picId || vH.album.picStr);
                this.kP.innerText = vH.name
            }
        }
        this.um()
    };
    bc.vE = function (be) {
        var en = this.IG.clientHeight, bXd = this.cW.parentNode.clientHeight;
        bb.ch(this.IG, "top", (bXd - en) / 2 + "px")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bM = bd("nej.ut"), bc;
    if (!!bM.bfc)return;
    bM.bfc = NEJ.C();
    bc = bM.bfc.bU(bM.dZ);
    bc.cz = function (bf) {
        this.cB(bf);
        this.RR = bf.to || cg;
        this.Hl = bf.from || {};
        this.cbo = Math.max(0, parseInt(bf.delay) || 0)
    };
    bc.cR = function () {
        this.cV();
        this.cu();
        if (!!this.Hi) {
            window.clearTimeout(this.Hi);
            delete this.Hi
        }
        delete this.RR;
        delete this.Hl
    };
    bc.bmZ = function (cT) {
        if (!this.Hl)return;
        if (("" + cT).indexOf(".") >= 0) cT = +(new Date);
        if (this.bmY(cT)) {
            this.cu();
            return
        }
        this.gl = requestAnimationFrame(this.bmZ.bi(this))
    };
    bc.bmY = cC;
    bc.hj = function () {
        var cbt = function () {
            this.Hi = window.clearTimeout(this.Hi);
            this.Hl.time = +(new Date);
            this.gl = requestAnimationFrame(this.bmZ.bi(this))
        };
        return function () {
            this.Hi = window.setTimeout(cbt.bi(this), this.cbo);
            return this
        }
    }();
    bc.cu = function () {
        this.gl = cancelRequestAnimationFrame(this.gl);
        this.bK("onstop");
        return this
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bm = bd("nej.u"), bM = bd("nej.ut"), bc, bO;
    if (!!bM.zQ)return;
    bM.zQ = NEJ.C();
    bc = bM.zQ.bU(bM.bfc);
    bO = bM.zQ.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.bfl = bf.duration || 200;
        this.cbx = 1 / (200 * this.bfl);
        this.cbE(bf.timing);
        this.cbG()
    };
    bc.cR = function () {
        this.cV();
        delete this.Es;
        delete this.bfq
    };
    bc.cbE = function () {
        var gK = /^cubic\-bezier\((.*?)\)$/i, jY = /\s*,\s*/i, bmQ = {
            linear: [0, 0, 1, 1],
            ease: [.25, .1, .25, 1],
            easein: [.42, 0, 1, 1],
            easeout: [0, 0, .58, 1],
            easeinout: [0, 0, .58, 1]
        };
        var cbJ = function (bD, bv, bk) {
            bk[bv] = parseFloat(bD)
        };
        return function (cnh) {
            cnh = (cnh || "").toLowerCase();
            this.Es = bmQ[cnh];
            if (gK.test(cnh)) {
                this.Es = RegExp.$1.split(jY);
                bm.cv(this.Es, cbJ)
            }
            if (!!this.Es)return;
            this.Es = bmQ.ease
        }
    }();
    bc.cbG = function () {
        var Er = this.Es, bfv = 3 * Er[0], bmO = 3 * (Er[2] - Er[0]) - bfv, cbM = 1 - bfv - bmO, bfy = 3 * Er[1], bmM = 3 * (Er[3] - Er[1]) - bfy, cbS = 1 - bfy - bmM;
        this.bfq = {ax: cbM, ay: cbS, bx: bmO, by: bmM, cx: bfv, cy: bfy}
    };
    bc.cbY = function () {
        var bmH = function (cT, oX) {
            return ((oX.ax * cT + oX.bx) * cT + oX.cx) * cT
        };
        var cca = function (cT, oX) {
            return ((oX.ay * cT + oX.by) * cT + oX.cy) * cT
        };
        var ccm = function (cT, oX) {
            return (3 * oX.ax * cT + 2 * oX.bx) * cT + oX.cx
        };
        var ccz = function (cT, bmy, oX) {
            var t0, t1, t2, x2, d2, i;
            for (t2 = cT, i = 0; i < 8; i++) {
                x2 = bmH(t2, oX) - cT;
                if (Math.abs(x2) < bmy)return t2;
                d2 = ccm(t2, oX);
                if (Math.abs(d2) < 1e-6)break;
                t2 = t2 - x2 / d2
            }
            t0 = 0;
            t1 = 1;
            t2 = cT;
            if (t2 < t0)return t0;
            if (t2 > t1)return t1;
            while (t0 < t1) {
                x2 = bmH(t2, oX);
                if (Math.abs(x2 - cT) < bmy)return t2;
                if (cT > x2) t0 = t2; else t1 = t2;
                t2 = (t1 - t0) * .5 + t0
            }
            return t2
        };
        return function (cjL) {
            return cca(ccz(cjL / this.bfl, this.cbx, this.bfq), this.bfq)
        }
    }();
    bc.bmY = function (cT) {
        var cjL = cT - this.Hl.time, wj = this.cbY(cjL), cq = bm.Lh(this.Hl.offset * (1 - wj) + this.RR.offset * wj, 2), pE = !1;
        if (cjL >= this.bfl) {
            cq = this.RR.offset;
            pE = !0
        }
        this.bK("onupdate", {offset: cq});
        return pE
    };
    bc.cu = function () {
        this.bK("onupdate", {offset: this.RR.offset});
        bO.cu.apply(this, arguments);
        return this
    }
})();
(function () {
    var bd = NEJ.P, bM = bd("nej.ut"), bc;
    if (!!bM.Ej)return;
    bM.Ej = NEJ.C();
    bc = bM.Ej.bU(bM.zQ);
    bc.cz = function (bf) {
        bf = NEJ.X({}, bf);
        bf.timing = "easein";
        this.cB(bf)
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bM = bd("nej.ut"), tR;
    bM.CT = NEJ.C();
    tR = bM.CT.bU(bM.dZ);
    tR.cz = function (bf) {
        this.cB(bf);
        this.bDc = !!bf.reset;
        this.WI = parseInt(bf.delta) || 0;
        this.jw = bb.bG(bf.track);
        this.bjR = bb.bG(bf.progress);
        this.dq([[bf.thumb, "mousedown", this.bDp.bi(this)], [document, "mousemove", this.bjT.bi(this)], [document, "mouseup", this.bjz.bi(this)], [this.jw, "mousedown", this.bDw.bi(this)]]);
        var jt = bf.value;
        if (jt == null) {
            jt = this.bjR.offsetWidth / this.jw.offsetWidth
        }
        this.hn(jt)
    };
    tR.cR = function () {
        if (!!this.bDc) this.UX(0);
        this.cV()
    };
    tR.bDp = function (be) {
        if (!!this.iL)return;
        bj.cu(be);
        this.iL = bj.mS(be);
        this.bjX = this.jw.offsetWidth
    };
    tR.bjT = function (be) {
        if (!this.iL)return;
        var cq = bj.mS(be), cjL = cq - this.iL;
        this.iL = cq;
        this.UX(this.CX + cjL / this.bjX);
        this.bK("onslidechange", {ratio: this.CX})
    };
    tR.bjz = function (be) {
        if (!this.iL)return;
        this.bjT(be);
        delete this.iL;
        delete this.bjX;
        this.bK("onslidestop", {ratio: this.CX})
    };
    tR.bDw = function (be) {
        var bDX = bb.jX(this.jw).x, bEL = bj.mS(be);
        this.UX((bEL - bDX + this.WI) / this.jw.offsetWidth);
        this.bK("onslidestop", {ratio: this.CX})
    };
    tR.UX = function (jt) {
        this.CX = Math.max(0, Math.min(1, jt));
        bb.ch(this.bjR, "width", this.CX * 100 + "%")
    };
    tR.hn = function (jt) {
        if (!!this.iL)return;
        this.UX(jt)
    };
    tR.bdj = function (jt) {
        return this.CX
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), gA = bd("nm.ut");
    gA.bYr = function () {
        var bdS = function (cH, fy, nP, nS, vT) {
            if (nP < nS) {
                var BX = Math.floor((nP + nS) / 2);
                bdS(cH, fy, nP, BX, vT);
                bdS(cH, fy, BX + 1, nS, vT);
                bYt(cH, fy, nP, BX, nS, vT)
            }
        };
        var bYt = function (cH, fy, nP, BX, nS, vT) {
            var i = nP, j = BX + 1, k = nP;
            while (i <= BX && j <= nS) {
                if (vT(cH[i], cH[j]) <= 0) {
                    fy[k++] = cH[i++]
                } else {
                    fy[k++] = cH[j++]
                }
            }
            while (i <= BX) {
                fy[k++] = cH[i++]
            }
            while (j <= nS) {
                fy[k++] = cH[j++]
            }
            for (i = nP; i <= nS; i++) {
                cH[i] = fy[i]
            }
        };
        var bYv = function (jQ, bYB) {
            return jQ < bYB
        };
        return function (cH, vT) {
            if (!cH || cH.length == 0)return cH;
            vT = vT || bYv;
            bdS(cH, new Array(cH.length), 0, cH.length - 1, vT);
            return cH
        }
    }();
    gA.bdY = function () {
        var gK = /\r\n|\r|\n/, jY = /\[(.*?)\]/gi, bdZ = {ar: "artist", ti: "track", al: "album", offset: "offset"};
        var bea = function (bp, iz) {
            var cH = [];
            iz = iz.replace(jY, function ($1, $2) {
                var cT = beb.call(this, bp, $2);
                if (cT != null) {
                    cH.push({time: cT, tag: $2});
                    bp.scrollable = !0
                }
                return ""
            }.bi(this)).trim();
            if (!cH.length) {
                if (!iz || iz.length == 0)return;
                cH.push({time: -1})
            }
            bm.cv(cH, function (bw) {
                bw.lyric = iz
            });
            var uP = bp.lines;
            uP.push.apply(uP, cH)
        };
        var beb = function (bp, cT) {
            var cH = cT.split(":"), sI = cH.shift(), bN = bdZ[sI];
            if (!!bN) {
                bp[bN] = cH.join(":");
                return null
            }
            sI = parseInt(sI);
            if (isNaN(sI)) {
                return null
            } else {
                var cq = parseInt(bp.offset) || 0;
                return sI * 60 + parseFloat(cH.join(".")) + cq / 1e3
            }
        };
        var bed = function (bee, bef) {
            return bee.time - bef.time
        };
        return function (bB, cm) {
            var bp = {id: bB, lines: [], scrollable: !1, source: cm};
            bm.cv((cm || "").trim().split(gK), bea.bi(null, bp));
            if (bp.scrollable) {
                gA.bYr(bp.lines, bed);
                var bv;
                for (var i = 0; i < bp.lines.length; i++) {
                    if (!!bp.lines[i].lyric) {
                        bv = i;
                        break
                    }
                }
                bp.lines.splice(0, bv)
            }
            return bp
        }
    }();
    gA.boe = function (sD, Rm) {
        var bek = gA.bdY(0, sD), bel = gA.bdY(0, Rm);
        if (bek.scrollable && bel.scrollable) {
            bm.cv(bek.lines, function (bw) {
                var Rn = getTranslate(bw.time);
                if (Rn) {
                    bw.lyric = bw.lyric + "<br>" + Rn.lyric
                }
            })
        }
        return bek;
        function getTranslate(cT) {
            var bv = bm.eg(bel.lines, function (bw) {
                return bw.time == cT
            });
            if (bv != -1) {
                return bel.lines[bv]
            }
        }
    }
})();
(function () {
    var bM = NEJ.P("nej.ut"), bmx;
    if (!!bM.Cc)return;
    bM.Cc = NEJ.C();
    bmx = bM.Cc.bU(bM.zQ);
    bmx.cz = function (bf) {
        bf = NEJ.X({}, bf);
        bf.timing = "linear";
        this.cB(bf)
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bA = bd("nej.j"), bm = bd("nej.u"), bn = bd("nm.x"), bo = bd("nm.l"), bq = bd("nm.d");
    var bod = function (bl) {
        if (bl.errorType == 6 || bl.errorType == 7 || bl.errorType == 8) {
            if (!bn.ic())return;
            bn.lg({txt: "m-report-point", title: "提示", onaction: bnZ.bi(this, bl)})
        } else {
            bnZ(bl)
        }
    };
    var bYL = function (be) {
        var bh = bj.bY(be, "d:action");
        if (bb.bz(bh, "action") == "feedLyric") {
            bj.cu(be);
            var dX = bb.bz(bh, "code"), bl = {songId: bb.bz(bh, "id"), errorType: dX};
            bod(bl)
        }
    };
    var bnZ = function (bl, be) {
        if (!be || be.action == "ok") {
            bA.cG("/api/v1/feedback/lyric", {
                type: "json", method: "post", data: bm.eX(bl), onload: function (be) {
                    if (be.code == 200) {
                        bo.ci.bR({tip: "提交成功"});
                        if (bm.hC(bl.onok)) {
                            bl.onok()
                        }
                    } else if (be.code == -2) {
                        bn.iu({
                            title: "提示", message: "您的积分不足", btnok: "赚积分", action: function (cl) {
                                if (cl == "ok") {
                                    location.dispatch2("/store/gain/index")
                                }
                            }
                        })
                    } else {
                        bo.ci.bR({type: 2, tip: "提交失败"})
                    }
                }
            })
        }
    };
    bn.bnT = function (bh) {
        var bh = bh || document.body, lI = bYL.bi(this);
        bj.bt(bh, "click", lI);
        return {
            destroy: function () {
                bj.oz(bh, "click", lI)
            }
        }
    };
    bn.cdA = function (bl) {
        bod(bl)
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bA = bd("nej.j"), bI = bd("nej.ut"), bM = bd("nej.p"), bq = bd("nm.d"), bn = bd("nm.x"), bo = bd("nm.l"), eT = bd("nm.ut"), bT = bd("nm.w"), bc, bO;
    var bdg = {};
    bT.boZ = NEJ.C();
    bc = bT.boZ.bU(bI.dZ);
    bc.cz = function (bf) {
        this.cB(bf);
        this.cW = bf.nlist;
        this.IR = bf.nmenu;
        this.bpg = bf.nask;
        this.tO = {track: bf.nscroll, slide: bb.eu(bf.nscroll)[0], content: this.cW, speed: 4};
        this.bcS = this.AP.bi(this);
        this.dq([[bf.nask, "click", this.bWZ.bi(this)], [this.tO.slide, "mousedown", this.SS.bi(this)], [document, "mouseup", this.SR.bi(this)], [bT.hB, "playaction", this.ud.bi(this)]]);
        if (bM.ek.browser != "firefox") {
            this.dq([[this.cW, "mousewheel", this.bcS]])
        } else {
            this.cW.addEventListener("DOMMouseScroll", this.bcS, false)
        }
        this.iJ = bT.ww.bF(this.tO);
        this.bcn = bn.bnT(this.cW);
        this.cO = bT.hB.iE()
    };
    bc.cR = function () {
        this.cV();
        delete this.vl;
        delete this.rU;
        delete this.PI;
        if (this.bcn) {
            this.bcn.destroy();
            delete this.bcn
        }
        if (bM.ek.browser == "firefox") {
            this.cW.removeEventListener("DOMMouseScroll", this.bcS)
        }
        bb.ch(this.IR, "display", "none")
    };
    bc.bWZ = function () {
        if (bb.ey(this.IR, "display") == "none") {
            bb.ch(this.IR, "display", "block")
        } else {
            bb.ch(this.IR, "display", "none")
        }
    };
    bc.bcg = function () {
        var kZ = 0;
        return function (Ju) {
            clearTimeout(kZ);
            this.PI = true;
            if (this.rU) {
                this.rU.bW();
                delete this.rU
            }
            if (!Ju) {
                kZ = setTimeout(function () {
                    delete this.PI
                }.bi(this), 3e3)
            }
        }
    }();
    bc.AP = function () {
        this.bcg()
    };
    bc.SS = function () {
        this.bcg(true)
    };
    bc.ud = function (be) {
        if (be.action == "timeupdate") {
            this.bpp(be.data.time, true)
        }
    };
    bc.bpp = function (cT, bWS) {
        if (!(this.vl && this.vl.scrollable) || this.PI)return;
        var i = this.vl.lines.length - 1, ii, cjL, bv = -1, bpr = 0, jB = 0;
        for (; i >= 0; i--) {
            ii = this.vl.lines[i];
            cjL = ii.time - cT;
            if (cjL < 0 && (i > 0 || cjL <= -2)) {
                bv = i;
                break
            }
        }
        for (var j = 0, jj; j < this.bcf.length; j++) {
            jj = this.bcf[j];
            if (j < bv) {
                bpr += jj.clientHeight
            }
            if (bv == j) {
                bb.bJ(jj, "z-sel")
            } else {
                bb.bH(jj, "z-sel")
            }
        }
        if (bv < 0 || bb.jX(this.bcf[bv], this.cW).y < 96) {
            jB = 0
        } else {
            jB = bpr - 96
        }
        if (Math.abs(jB - this.cW.scrollTop) <= 4 || this.rU)return;
        if (bWS) {
            var dG = {
                from: {offset: this.cW.scrollTop}, to: {offset: jB}, duration: 500, onupdate: function (be) {
                    this.cW.scrollTop = be.offset;
                    this.iJ.DG(this.cW.scrollTop / (this.cW.scrollHeight - this.cW.clientHeight))
                }.bi(this), onstop: function () {
                    if (this.rU) {
                        this.rU.bW();
                        delete this.rU
                    }
                }.bi(this)
            };
            this.rU = bI.Cc.bF(dG);
            this.rU.hj()
        } else {
            this.cW.scrollTop = jB;
            this.iJ.DG(this.cW.scrollTop / (this.cW.scrollHeight - this.cW.clientHeight))
        }
    };
    bc.bXi = function (co) {
        this.PH = co;
        delete this.vl;
        if (co && !co.program) {
            var bZ = "/api/song/lyric", cN = {id: co.id, lv: -1, tv: -1};
            if (bdg[co.id]) {
                this.bcb(bdg[co.id])
            } else {
                bA.cG(bZ, {
                    sync: false,
                    type: "json",
                    query: cN,
                    method: "get",
                    onload: this.bcb.gY(this, co.id),
                    onerror: this.bcb.bi(this)
                })
            }
            bb.bH(this.bpg, "f-hide")
        } else {
            bb.bJ(this.bpg, "f-hide");
            this.SN({})
        }
    };
    bc.bcb = function (be, bB) {
        if (be.code == 200) {
            if (bB) {
                bdg[bB] = be
            }
            var sD = be.lrc || {}, Rn = be.tlyric || {};
            if (!sD.lyric) {
                this.SN(be)
            } else {
                this.vl = eT.boe(sD.lyric, Rn.lyric);
                be.scrollable = this.vl.scrollable;
                bb.fR(this.cW, "m-lyric-line", {id: this.PH.id, lines: this.vl.lines, scrollable: this.vl.scrollable});
                this.bcf = bb.bP(this.cW, "j-flag")
            }
            be.songId = this.PH.id;
            bb.fR(this.IR, "m-player-lyric-ask", be)
        } else {
        }
        if (this.rU) {
            this.rU.bW();
            delete this.rU
        }
        this.iJ.os();
        this.bpp(this.cO.Yk() || 0, false)
    };
    bc.SR = function () {
        if (this.PI) {
            this.bcg()
        }
    };
    bc.SN = function (bl) {
        if (this.PH.program) {
            this.cW.innerHTML = '<div class="nocnt nolyric"><span class="s-fc4">电台节目，无歌词</span></div>'
        } else if (bl.nolyric) {
            this.cW.innerHTML = '<div class="nocnt nolyric"><span class="s-fc4">纯音乐，无歌词</span></div>'
        } else {
            this.cW.innerHTML = '<div class="nocnt nolyric"><span class="s-fc4">暂时没有歌词</span><a data-action="feedLyric" data-code="6"' + "data-id=" + this.PH.id + ' href="#" class="f-tdu">求歌词</a></div>'
        }
        this.iJ && this.iJ.os()
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), ej = bd("nej.p"), bA = bd("nej.j"), bI = bd("nej.ut"), bq = bd("nm.d"), bo = bd("nm.l"), bn = bd("nm.x"), eT = bd("nm.u"), bT = bd("nm.w"), bL = bd("nm.m.f"), hF = bd("player"), bc, bO;
    bL.KA = NEJ.C();
    bc = bL.KA.bU(bI.dZ);
    bc.dv = function () {
        this.dC();
        this.NN = bb.bG("g_player");
        this.pI = this.NN.parentNode;
        var bk = bb.bP(this.NN, "j-flag");
        this.hr = bk[0];
        this.oA = bk[1];
        this.kP = bk[2];
        this.FM = bk[3];
        this.lm = bk[4];
        this.jc = bk[5];
        bk = bb.eu(bk[6]);
        this.zb = bk[0];
        this.Ps = bk[1];
        this.bpA = bk[2];
        this.QG = bk[3];
        this.bbC = bk[4];
        this.bbA = bb.eu(this.QG)[0];
        this.xK = bn.Xo();
        this.Po(3e3);
        this.bbw();
        this.bWo();
        this.bWn();
        this.bpI();
        this.bLV();
        hF.setLike = this.bpJ.bi(this);
        bj.bt(this.pI, "click", this.cS.bi(this));
        bj.bt(bT.hB, "playaction", this.ud.bi(this));
        bj.bt(bT.rJ, "queuechange", this.um.bi(this));
        bj.bt(bT.rJ, "playchange", this.iH.bi(this));
        bj.bt(this.pI, ej.ek.browser == "ie" ? "mouseleave" : "mouseout", this.bpK.bi(this, !1));
        bj.bt(this.pI, ej.ek.browser == "ie" ? "mouseenter" : "mouseover", this.bpK.bi(this, !0));
        bj.bt(document, "keyup", this.bpL.bi(this));
        bj.bt(window, "iframeclick", this.rf.bi(this));
        bj.bt(document, "click", this.rf.bi(this));
        bj.bt(this.zb, "click", bj.cu.bi(bj));
        hF.hotkeys = this.bpL.bi(this);
        this.bpM = bm.nY()
    };
    bc.bLV = function () {
        var brJ = bb.bG("g-topbar"), eZ = this.NN.offsetWidth, cls = this.pI.offsetWidth;
        if (!brJ)return;
        bb.ch(this.NN, "marginLeft", -(cls - brJ.offsetWidth + this.NN.offsetWidth) / 2 + "px")
    };
    bc.bpI = function () {
        if (this.xK.lock) {
            bb.bH(this.pI, "m-playbar-unlock");
            bb.bJ(this.pI, "m-playbar-lock");
            window.g_bottomBarHeight = 47
        } else {
            bb.bJ(this.pI, "m-playbar-unlock");
            bb.bH(this.pI, "m-playbar-lock");
            window.g_bottomBarHeight = 0
        }
    };
    bc.bbw = function () {
        var bk = bb.eu(this.FM);
        this.bpN = bk[0];
        this.Pm = bb.eu(bk[1])[0];
        this.bpP = bI.CT.bF({
            track: this.FM, thumb: this.Pm, progress: bk[1], onslidestop: function (be) {
                this.bpQ = false;
                this.cO.qH(this.cO.Yd() * be.ratio)
            }.bi(this), onslidechange: function (be) {
                this.bpQ = true;
                this.bbs({time: be.ratio * this.cO.Yd(), duration: this.cO.Yd()})
            }.bi(this)
        })
    };
    bc.bWn = function () {
        var bk = bb.bP(this.zb, "j-t"), jt = bk[1], yf = this.xK.volume;
        if (yf == null) {
            yf = .8
        }
        this.Hc = bI.EP.bF({
            track: bk[0], slide: bk[2], onchange: function (be) {
                var bD = 1 - be.y.rate, en = 93 * bD;
                bb.ch(jt, "height", en + "px");
                en > 0 ? bb.bH(this.Ps, "icn-volno") : bb.bJ(this.Ps, "icn-volno");
                this.cO.oF(bD);
                this.xK.volume = bD;
                bn.Dh(this.xK)
            }.bi(this)
        });
        this.Hc.hn({x: 0, y: 1 - yf})
    };
    bc.bWo = function () {
        var cN = bm.iO(location.hash.slice(1)) || {}, bu = cN["__media"] || this.xK.useFlash && "flash" || "auto";
        this.cO = bT.hB.iE({media: bu});
        this.ho = bT.rJ.iE();
        hF.addTo = function (jl, qO, fQ) {
            this.ho.bXC(JSON.parse(JSON.stringify(jl)), qO, fQ)
        }.bi(this);
        hF.tipPlay = this.bbp.bi(this);
        hF.getPlaying = function () {
            return {track: this.ho.qz(), playing: this.cO.uv()}
        }.bi(this);
        hF.pause = this.cO.iC.bi(this.cO);
        var hb = this.ho.qz();
        if (hb) {
            this.bpT(hb)
        }
        this.bpU(this.ho.bXH());
        this.bpV()
    };
    bc.um = function () {
        var kZ = 0;
        return function (be) {
            if (be.cmd == "play" || be.cmd == "addto") {
                this.bbp(be.cmd == "play" ? "已开始播放" : "已添加到播放列表")
            }
            this.bpV()
        }
    }();
    bc.iH = function (be) {
        var co = be["new"];
        this.bpT(co);
        if (this.cO.uv()) {
            document.title = decodeURIComponent("%E2%96%B6%20") + co.name
        }
        bj.bK(window, "playchange", {trackId: co.id, track: co})
    };
    bc.cS = function (be) {
        var bh = bj.bY(be, "d:action"), cl = bb.bz(bh, "action"), uQ = bj.bY(be, "a:href");
        if (uQ && uQ.tagName.toLocaleLowerCase() == "a" && /^http/.test(uQ.href)) {
            this.bW();
            return
        } else {
            bj.cu(be)
        }
        switch (cl) {
            case"lock":
                this.xK.lock = !bb.cU(this.pI, "m-playbar-lock");
                bn.Dh(this.xK);
                this.bpI();
                break;
            case"prev":
                this.ho.Dz();
                break;
            case"next":
                this.ho.qC();
                break;
            case"play":
                this.cO.hj();
                break;
            case"pause":
                this.cO.iC();
                break;
            case"like":
                var co = this.ho.qz();
                if (co) {
                    window.subscribe(co, co.program)
                }
                !co.program && this.rZ && this.rZ.bW();
                break;
            case"share":
                var co = this.ho.qz();
                if (co) {
                    !co.program ? bn.sd({
                            rid: co.id,
                            type: 18,
                            purl: co.album.picUrl,
                            name: co.name,
                            author: bn.vj(co.artists)
                        }) : bn.sd({
                            rid: co.program.id,
                            type: 17,
                            purl: co.program.coverUrl,
                            name: co.program.name,
                            author: (co.program.radio || []).name
                        })
                }
                this.rZ && this.rZ.bW();
                break;
            case"mode":
                this.bpU(this.ho.bXI(), true);
                break;
            case"volume":
                bj.cu(be);
                if (this.zb.style.visibility != "hidden") {
                    bb.ch(this.zb, "visibility", "hidden")
                } else {
                    bb.ch(this.zb, "visibility", "visible")
                }
                break;
            case"panel":
                bj.cu(be);
                if (!this.rZ) {
                    this.rZ = bL.boT.bF({
                        parent: this.pI, onclose: function () {
                            delete this.rZ;
                            this.Po()
                        }.bi(this)
                    })
                } else {
                    if (this.rZ) {
                        this.rZ.bW();
                        delete this.rZ
                    }
                }
                break
        }
    };
    bc.bbs = function (be) {
        this.lm.innerHTML = bn.fX("<em>{0}</em> / {1}", bn.nJ(be.time), bn.nJ(be.duration))
    };
    bc.bpU = function (fC, dS) {
        var cE = {
            2: {icn: "icn-one", title: "单曲循环"},
            4: {icn: "icn-loop", title: "循环"},
            5: {icn: "icn-shuffle", title: "随机"}
        }, cj  = cE[fC];
        bb.gL(this.bpA, "icn-one icn-loop icn-shuffle", cj.icn);
        this.bbC.innerText = this.bpA.title = cj.title;
        clearTimeout(this.bWc);
        if (dS) {
            bb.ch(this.bbC, "display", "");
            this.bWc = setTimeout(function () {
                bb.ch(this.bbC, "display", "none")
            }.bi(this), 2e3)
        }
    };
    bc.bpJ = function (dN) {
        var hb = this.ho.qz();
        if (hb && hb.program && hb.program.id == dN.id) {
            hb.program.liked = dN.liked;
            this.jc.title = "赞";
            if (dN.liked) {
                bb.gL(this.jc, "icn-zan", "icn-yizan")
            } else {
                bb.gL(this.jc, "icn-yizan", "icn-zan")
            }
            this.ho.QO()
        }
    };
    bc.bpT = function (co) {
        var cP;
        bb.ch(this.bpN, "width", 0);
        this.bbs(0);
        this.bpP.hn(0);
        if (co) {
            cP = this.bVY(co);
            if (co.program) {
                bb.gL(this.jc, "icn-add", "icn-zan");
                this.jc.title = "赞";
                bA.rV(this.qG);
                this.qG = bA.cG("/api/dj/program/detail", {
                    type: "json",
                    query: {id: co.program.id},
                    onload: function (be) {
                        if (be.code == 200) {
                            this.bpJ(be.program)
                        }
                    }.bi(this)
                })
            } else {
                bb.gL(this.jc, "icn-zan icn-yizan", "icn-add");
                this.jc.title = "收藏"
            }
            this.oA.innerHTML = bn.fX('<img src="{0}?param=34y34"><a href="{1}" hidefocus="true" class="mask"></a>', cP.cover, cP.titleUrl);
            bb.fR(this.kP, "m-player-playinfo", cP)
        }
    };
    bc.bpV = function () {
        var bk = bb.eu(this.QG);
        bk[1].innerText = this.ho.kW()
    };
    bc.bVY = function (co) {
        var bp = {
            duration: co.duration,
            cover: "http://s4.music.126.net/style/web2/img/default_album.jpg",
            source: co.source
        };
        if (co.program) {
            bp.type = "program";
            bp.name = bm.fd(co.program.name);
            bp.cover = co.program.coverUrl;
            bp.titleUrl = "/program?id=" + co.program.id;
            bp.artistHtml = bn.fX('<a hidefocus="true" href="/radio?id={0}" title="{1}">{1}</a>', co.program.radio.id, bm.fd(co.program.radio.name))
        } else {
            bp.type = "song";
            bp.name = co.name;
            bp.mvid = co.mvid;
            if (!co.album) {
                co.album = {}
            }
            if (co.album.pic && co.album.picUrl) {
                bp.cover = co.album.picUrl
            }
            bp.titleUrl = "/song?id=" + co.id;
            bp.artistHtml = bn.ph(co.artists)
        }
        return bp
    };
    bc.ud = function (be) {
        var bl = be.data;
        switch (be.action) {
            case"play":
                bb.bJ(this.hr, "pas");
                bb.bz(this.hr, "action", "pause");
                bA.hI("playerid", this.bpM);
                var co = this.ho.qz();
                if (co) {
                    document.title = decodeURIComponent("%E2%96%B6%20") + co.name
                }
                bj.bK(window, "playstatechange", be);
                break;
            case"pause":
                bb.bH(this.hr, "pas");
                bb.bz(this.hr, "action", "play");
                document.title = this.bVT() || "网易云音乐";
                break;
            case"timeupdate":
                if (this.bpQ)return;
                var jg = bA.hI("playerid");
                if (jg && jg !== this.bpM) {
                    this.cO.iC()
                }
                this.bpP.hn(bl.time / bl.duration);
                this.bbs(bl);
                break;
            case"progress":
                bb.ch(this.bpN, "width", bl.loaded * 100 / bl.total + "%");
                break;
            case"error":
                this.bbp("播放失败");
                bb.bH(this.Pm, "z-load");
                break;
            case"playing":
                bb.bH(this.Pm, "z-load");
                break;
            case"waiting":
                bb.bJ(this.Pm, "z-load");
                break
        }
    };
    bc.bbp = function () {
        var kZ = 0;
        return function (hO) {
            if (hO) {
                this.bbA.innerText = hO;
                bb.ch(this.bbA, "display", "");
                clearTimeout(kZ);
                kZ = setTimeout(function () {
                    bb.ch(this.bbA, "display", "none")
                }.bi(this), 2e3);
                this.Lu(true);
                this.Po(2e3)
            }
        }
    }();
    bc.bpK = function (xC, be) {
        if (!this.rZ) {
            if (xC) {
                if (!bn.Qm(this.pI, be.relatedTarget || be.fromElement)) {
                    this.Lu(true)
                }
            } else {
                if (!bn.Qm(this.pI, be.relatedTarget || be.toElement)) {
                    this.Po()
                }
            }
        }
    };
    bc.Po = function (wz) {
        clearTimeout(this.bqc);
        this.bqc = setTimeout(function () {
            if (!this.xK.lock) {
                this.Lu(false)
            }
        }.bi(this), wz || 500)
    };
    bc.Lu = function () {
        var wG, OU = true;
        return function (ly) {
            clearTimeout(this.bqc);
            if (wG || ly == OU)return;
            OU = ly;
            wG = bI.Ej.bF({
                to: {offset: ly ? -53 : -7}, from: {offset: ly ? -7 : -53}, onstop: function () {
                    wG.bW();
                    wG = null
                }, onupdate: function (be) {
                    bb.ch(this.pI, "top", be.offset + "px")
                }.bi(this), duration: ly ? 100 : 350
            });
            wG.hj()
        }
    }();
    bc.bpL = function (be) {
        if (be.keyCode == 80 && !bn.buB()) {
            this.cO.uv() ? this.cO.iC() : this.cO.hj()
        } else if (be.ctrlKey) {
            switch (be.keyCode) {
                case 37:
                    this.ho.Dz();
                    break;
                case 39:
                    this.ho.qC();
                    break
            }
        }
    };
    bc.rf = function () {
        bb.ch(this.zb, "visibility", "hidden");
        this.rZ && this.rZ.bW()
    };
    bc.bVT = function () {
        var fU = bb.bG("g_iframe");
        if (fU) {
            return fU.contentWindow.document.title
        } else {
            return ""
        }
    };
    bc.bR = function () {
        window.g_bottomBarShow = true;
        bb.ch(this.pI, "visibility", "visible")
    };
    bc.cw = function () {
        window.g_bottomBarShow = false;
        this.cO.iC();
        bb.ch(this.pI, "visibility", "hidden")
    }
})();
(function () {
    var bd = NEJ.P, fm = window, cC = NEJ.F, bA = bd("nej.j"), bn = bd("nm.x"), bq = bd("nm.d"), bc, bO;
    bq.fX({
        "netease-login": {url: "/api/login", onload: "onlogin", onerror: "onloginerror"},
        "captcha-send": {
            url: "/api/sms/captcha/sent",
            onload: "onsendcaptcha",
            onerror: "onsendcaptchaerror",
            format: function (bp, bf) {
                bp.mobile = bf.data.cellphone;
                return bp
            }
        },
        "captcha-verify": {
            url: "/api/sms/captcha/verify",
            onload: "onverifycaptcha",
            onerror: "onverifycaptchaerror",
            format: function (bp, bf) {
                bp.mobile = bf.data.cellphone;
                bp.captcha = bf.data.captcha;
                return bp
            }
        },
        "mobile-login": {url: "/api/login/cellphone", onload: "onmobilelogin", onerror: "onmobileloginerror"},
        "mobile-check": {
            url: "/api/cellphone/existence/check",
            onload: "onmobilecheck",
            onerror: "onmobilecheckerror",
            format: function (bp, bf) {
                bp.mobile = bf.data.cellphone;
                bp.captcha = bf.data.captcha;
                return bp
            }
        },
        "mobile-regist": {url: "/api/register/cellphone", onload: "onmobileregist", onerror: "onmobileregisterror"},
        "mobile-updatepwd": {
            url: "/api/login/password/update",
            onload: "onmobileupdatepwd",
            onerror: "onmobileupdatepwderror",
            format: function (bp, bf) {
                bp.mobile = bf.data.phone;
                bp.password = bf.data.password;
                return bp
            }
        },
        "mobile-resetpwd": {
            url: "/api/login/password/reset",
            onload: "onmobileresetpwd",
            onerror: "onmobileresetpwderror",
            format: function (bp, bf) {
                bp.mobile = bf.data.phone;
                bp.password = bf.data.password;
                return bp
            }
        },
        "nickname-set": {url: "/api/activate/initProfile", onload: "onactive", onerror: "onactiveerror"},
        logout: {url: "/logout", onload: "onlogout"},
        "logout-quiet": {url: "/logout"},
        "oauth-nickname": {url: "/oauth/init_profile", onload: "onactive", onerror: "onactiveerror"},
        "mobile-nickname": {url: "/oauth/register/cellphone", onload: "onmobileregist", onerror: "onmobileregisterror"},
        "mobile-bind": {
            url: "/api/user/bindingCellphone",
            onload: "onmobilebind",
            onerror: "onmobilebinderror",
            format: function (bp, bf) {
                bp.mobile = bf.data.phone;
                bp.captcha = bf.data.captcha;
                return bp
            }
        },
        "mobile-relogin": {url: "/api/mainAccount/set", onload: "onmobilelogin", onerror: "onmobileloginerror"},
        "mainaccount-replace": {
            url: "/api/user/replaceMainAccount",
            onload: "onmainaccountreplace",
            onerror: "onmainaccountreplaceerror"
        },
        "binding-delete": {url: "/api/user/deleteBinding", onload: "ondeletebinding", onerror: "ondeletebindingerror"},
        "mobile-change": {
            url: "/api/v1/user/replaceCellphone",
            onload: "onchangemobile",
            onerror: "onchangemobileerror"
        },
        "urs-bind": {url: "/api/user/bindingUrs", onload: "onbindurs", onerror: "onbindurserror"}
    });
    bq.mA = NEJ.C();
    bc = bq.mA.bU(bq.ik);
    bc.bKC = function (bf) {
        bf = bf || {};
        this.dJ(bq.bG("logout"), bf)
    };
    bc.cfF = function (bf) {
        bf = bf || {};
        this.dJ(bq.bG("logout-quiet"), bf)
    };
    bc.bwT = function (bf) {
        this.dJ(bq.bG("netease-login"), bf)
    };
    bc.Bn = function (bf) {
        this.dJ(bq.bG("captcha-send"), bf)
    };
    bc.bKJ = function (bf) {
        this.dJ(bq.bG("captcha-verify"), bf)
    };
    bc.bKK = function (bf) {
        this.dJ(bq.bG("mobile-login"), bf)
    };
    bc.bhq = function (bf) {
        this.dJ(bq.bG("mobile-check"), bf)
    };
    bc.Qu = function (bf) {
        this.dJ(bq.bG("mobile-regist"), bf)
    };
    bc.cfD = function (bf) {
        this.dJ(bq.bG("mobile-resetpwd"), bf)
    };
    bc.Qt = function (bf) {
        this.dJ(bq.bG("mobile-updatepwd"), bf)
    };
    bc.bhv = function (bf) {
        this.dJ(bq.bG("nickname-set"), bf)
    };
    bc.cfC = function (bf) {
        this.dJ(bq.bG("oauth-nickname"), bf)
    };
    bc.cfB = function (bf) {
        this.dJ(bq.bG("mobile-nickname"), bf)
    };
    bc.bhy = function (bf) {
        this.dJ(bq.bG("mobile-bind"), bf)
    };
    bc.cfA = function (bf) {
        this.dJ(bq.bG("mobile-relogin"), bf)
    };
    bc.cfz = function (bf) {
        this.dJ(bq.bG("mainaccount-replace"), bf)
    };
    bc.bhB = function (bf) {
        this.dJ(bq.bG("binding-delete"), bf)
    };
    bc.bLl = function (bf) {
        this.dJ(bq.bG("mobile-change"), bf)
    };
    bc.bLm = function (bf) {
        this.dJ(bq.bG("urs-bind"), bf)
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bA = bd("nej.j"), bI = bd("nej.ut"), cA = bd("nej.ui"), bm = bd("nej.u"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), bc;
    bT.Fm = NEJ.C();
    bc = bT.Fm.bU(cA.gh);
    bc.cz = function (bf) {
        this.cB(bf);
        if (bf.txt) {
            this.bs.innerHTML = bb.jZ(bf.txt)
        } else if (bf.html) {
            this.bs.innerHTML = bf.html
        }
        this.xo = bf.captchaId;
        var bk = bb.bP(this.bs, "j-flag");
        this.fu = bk[0];
        this.gZ = bk[1];
        this.dq([[this.gZ, "click", this.bhJ.bi(this)], [this.fu, "keypress", this.bLs.bi(this)]]);
        this.gZ.src = "/captcha?id=" + this.xo
    };
    bc.cR = function () {
        this.cV()
    };
    bc.bhJ = function () {
        bA.cG("/api/image/captcha/verify/hf", {
            type: "json", query: {id: this.xo, captcha: 0}, onload: function (bp) {
                if (bp.code == 200) {
                    this.xo = bp.captchaId;
                    this.gZ.src = "/captcha?id=" + this.xo
                }
            }.bi(this)
        })
    };
    bc.bLs = function (be) {
        if (be.keyCode == 13) this.bK("onaction", be)
    };
    bc.xf = function () {
        var bp = {}, dX = this.fu.value;
        if (!dX) {
            bp.message = "请输入验证码"
        } else {
            bA.cG("/api/image/captcha/verify/hf", {
                type: "json",
                sync: true,
                query: {id: this.xo, captcha: dX},
                onload: cbVerify.bi(this),
                onerror: cbVerify.bi(this)
            })
        }
        return bp;
        function cbVerify(be) {
            if (be.code == 200) {
                if (be.result) {
                    bp.success = true
                } else {
                    bp.message = "验证码错误";
                    if (be.captchaId) {
                        this.xo = be.captchaId;
                        this.gZ.src = "/captcha?id=" + this.xo
                    }
                }
            } else {
                bp.message = "验证出错"
            }
        }
    };
    bc.gn = function () {
        return this.fu.value
    };
    bc.zR = function () {
        return this.xo
    };
    bc.bJ = function (qK) {
        bb.bJ(this.fu, qK)
    };
    bc.bH = function (qK) {
        bb.bH(this.fu, qK)
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bj = bd("nej.v"), bb = bd("nej.e"), bA = bd("nej.j"), bo = bd("nm.l"), bT = bd("nm.w"), di = bd("nej.ui"), bq = bd("nm.d"), bn = bd("nm.x"), bc, bO;
    bo.bhP = NEJ.C();
    bc = bo.bhP.bU(bo.fz);
    bO = bo.bhP.dr;
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.fu = bk[0];
        this.fO = bk[1];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.dx = function () {
        this.dy = "m-captcha-layer"
    };
    bc.cz = function (bf) {
        bf.clazz = "m-layer-captcha";
        bf.parent = bf.parent || document.body;
        bf.title = "输入验证码";
        bf.draggable = !0;
        bf.destroyable = true;
        bf.mask = true;
        this.cB(bf);
        this.dn = bT.Fm.bF({
            parent: this.fu,
            html: '<input class="u-txt txt f-fl j-flag"/><img class="captcha f-fl j-flag" src=""/>',
            captchaId: bf.captchaId
        })
    };
    bc.cR = function () {
        this.bK("ondestroy");
        this.cV();
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
    };
    bc.cS = function (be) {
        var bh = bj.bY(be, "d:action");
        switch (bb.bz(bh, "action")) {
            case"ok":
                var cP = this.dn.xf();
                if (!cP.success) {
                    this.fO.innerHTML = '<i class="u-icn u-icn-25"></i>' + cP.message;
                    bb.bH(this.fO, "f-hide")
                } else {
                    bb.bJ(this.fO, "f-hide");
                    this.cw()
                }
                break;
            case"cc":
                this.cw();
                break
        }
    };
    bn.bwy = function (bf) {
        bo.bhP.bF(bf).bR()
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bA = bd("nej.j"), cg = bd("nej.o"), bm = bd("nej.u"), bj = bd("nej.v"), di = bd("nej.ui"), bq = bd("nm.d"), bn = bd("nm.x"), bo = bd("nm.l"), bc, bO;
    bo.ox = NEJ.C();
    bc = bo.ox.bU(bo.fz, !0);
    bc.dv = function () {
        this.dC()
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.sX = bk[0];
        bj.bt(bk[1], "click", this.bjp.bi(this))
    };
    bc.dx = function () {
        this.dy = "m-layer-tip"
    };
    bc.cz = function (bf) {
        bf.parent = bf.parent || document.body;
        this.cB(bf);
        this.sX.innerHTML = bf.mesg || ""
    };
    bc.cR = function () {
        this.cV()
    };
    bc.bjp = function (be) {
        this.bK("onnotice");
        this.cw()
    };
    bo.mo = function (bf) {
        if (this.wn) {
            this.wn.bW();
            delete this.wn
        }
        this.wn = bo.ox.bF(bf);
        this.wn.bR()
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bj = bd("nej.v"), bA = bd("nej.j"), bI = bd("nej.ut"), bb = bd("nej.e"), bm = bd("nej.u"), bo = bd("nm.l"), bn = bd("nm.x"), bq = bd("nm.d"), lM = bd("nm.ctl"), bc;
    if (lM.bjr)return;
    lM.bjr = NEJ.C();
    bc = lM.bjr.bU(bI.dZ);
    var bMQ = location.host == "music.163.com";
    if (bMQ) {
        var cX = {
            host: "s2.music.126.net",
            scaptcha_server: "captcha.aq.163.com/v1_5",
            scaptcha_product_key: "nj2vr7swvutssrtbj16kzfentkikkvbf"
        }
    } else {
        var cX = {
            host: location.host,
            scaptcha_server: "captcha.aq.163.com/v1_5",
            scaptcha_product_key: "nj2vr7swvutssrtbj16kzfentkikkvbf"
        }
    }
    bc.BF = function (bMU) {
        return location.protocol + "//" + cX.host + bMU
    };
    bc.bvu = function (bN) {
        return NEJ.Q(cX, bN)
    };
    bd("ctl").env = lM.bjr.iE()
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bM = bd("nej.p"), bb = bd("nej.e"), bj = bd("nej.v"), bA = bd("nej.j"), bI = bd("nej.ut"), bm = bd("nej.u"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), bc;
    if (bT.bjx)return;
    bT.bjx = NEJ.C();
    bc = bT.bjx.bU(bI.dZ);
    bc.dv = function () {
        this.bvt = [location.protocol + "//captcha.aq.163.com/v1_5/js/c.js"];
        if (bM.ek && bM.ek.engine == "trident" && nej.p.ek.release - 5 < 0) {
            this.bvt.unshift(ctl.env.BF("/static/web2/3rd/scaptcha/ie6support.js"))
        }
        this.dC()
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.dn = "";
        this.gX = bf.parent;
        this.bvs = {server: bf.server, productKey: bf.productKey, width: bf.width, verifyCallback: this.Be.bi(this)};
        this.PF(0);
        this.bNb()
    };
    bc.cR = function () {
        delete this.bjE;
        delete this.bvs;
        delete this.gX;
        delete this.dn;
        this.cV()
    };
    bc.bNb = function () {
        if (this.bjE > 0)return;
        this.PF(1);
        this.bvp()
    };
    bc.bvp = function () {
        var bvo = this.bvt.shift();
        if (!bvo) {
            this.PF(2);
            this.hP()
        } else {
            bA.bXn(bvo, {onloaded: this.bvp.bi(this), onerror: this.PF.bi(this, 3)})
        }
    };
    bc.PF = function (bvn) {
        this.bjE = bvn;
        this.bK("onloadstatechange", {loadState: bvn})
    };
    bc.Be = function (be) {
        setTimeout(this.bNd.bi(this, be), 0)
    };
    bc.bNd = function (be) {
        if (be.value) {
            this.dn = bb.ix(this.gX, "pwd")
        } else {
            this.dn = ""
        }
        this.bK("onverify", {success: be.value})
    };
    bc.hP = function () {
        if (this.bjE == 2) {
            this.dn = "";
            if (bm.hC(window.scaptcha)) {
                window.scaptcha(this.gX, this.bvs)
            }
        }
    };
    bc.bNu = function () {
        return this.dn
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bA = bd("nej.j"), bq = bd("nm.d"), bo = bd("nm.l"), bn = bd("nm.x"), bT = bd("nm.w"), bc, bO;
    bo.Bb = NEJ.C();
    bc = bo.Bb.bU(bo.fz);
    bO = bo.Bb.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.ed = bf;
        this.dn = bT.bjx.bF({
            parent: this.bNv,
            server: ctl.env.bvu("scaptcha_server"),
            productKey: ctl.env.bvu("scaptcha_product_key"),
            width: 220,
            onverify: this.Be.bi(this)
        })
    };
    bc.cR = function () {
        this.cV();
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
    };
    bc.dx = function () {
        this.dy = "ntp-setnickname"
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "js-flag");
        this.fK = bk.shift();
        bb.gj(this.fK, "holder");
        bj.bt(this.fK, "focus", this.gI.bi(this));
        bj.bt(this.fK, "keypress", this.KB.bi(this));
        bj.bt(this.fK, "keyup", this.Vn.bi(this));
        this.bNv = bk.shift();
        this.fO = bk.shift();
        this.du = bk.shift();
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.bR = function () {
        bO.bR.apply(this, arguments);
        this.dh(false);
        this.dF(false);
        this.fK.value = "";
        this.dn.hP()
    };
    bc.gI = function () {
        bb.bH(this.fK, "u-txt-err")
    };
    bc.KB = function (be) {
        if (be.keyCode == 13) this.yu()
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"ok":
                this.yu(be);
                break
        }
    };
    bc.yu = function (be) {
        bj.dp(be);
        if (this.dF())return;
        if (!(this.up = this.Px()))return;
        var cmD = this.dn.bNu();
        if (!cmD.trim())return this.dh("请输入验证码", "captcha");
        if (this.ed.onok) {
            this.dF(true);
            this.ed.onok({nickname: this.up, dragPwd: cmD})
        }
    };
    bc.Be = function (be) {
        if (be.success) {
            this.dh(false);
            if (this.fK.value.trim()) {
                this.yu()
            }
        } else {
            this.dh("验证码错误", "captcha")
        }
    };
    bc.Px = function () {
        var iU = this.fK.value.trim(), cmK = iU.replace(/[^\x00-\xff]/g, "**");
        if (!iU)return this.dh("请输入昵称", "nickname");
        if (cmK.length < 4 || cmK.length > 30)return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        if (!/^[\u4e00-\u9fa5A-Za-z0-9-_]*$/.test(iU))return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        return iU
    };
    bc.Vn = function (be) {
        var iU = this.fK.value.trim(), cmK = iU.replace(/[^\x00-\xff]/g, "**");
        if (this.Vu == iU)return;
        this.Vu = iU;
        if (be.keyCode == 13)return;
        if (/[^\u4e00-\u9fa5\w-]/.test(iU))return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        if (iU && cmK.length > 30)return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        this.dh(false)
    };
    bc.dh = function (cZ, iD, bNA) {
        this.eH(this.fO, cZ);
        bb.bH(this.fK, "u-txt-err");
        if (iD == "nickname") {
            bb.bJ(this.fK, "u-txt-err")
        } else if (iD == "captcha") {
        }
        if (bNA) {
            this.dn.hP()
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, "开启云音乐", "设置中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bq = bd("nm.d"), bo = bd("nm.l"), bn = bd("nm.x"), bc, bO;
    bo.qq = NEJ.C();
    bc = bo.qq.bU(bo.fz);
    bO = bo.qq.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onsendcaptcha", this.wK.bi(this));
        this.bS.bt("onsendcaptchaerror", this.KK.bi(this));
        this.bS.bt("onverifycaptcha", this.bNE.bi(this));
        this.bS.bt("onverifycaptchaerror", this.bNG.bi(this));
        if (this.gl) this.gl = clearInterval(this.gl)
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW()
    };
    bc.dx = function () {
        this.dy = "ntp-verifycaptcha"
    };
    bc.dm = function () {
        this.dw();
        this.dA = bb.bP(this.bs, "js-tip")[0];
        var KM = bb.bP(this.bs, "js-mobwrap");
        this.buP = KM[0];
        this.buM = KM[1];
        this.hx = bb.bP(this.bs, "js-mob")[0];
        this.bNJ = bb.bP(this.bs, "js-lbl")[0];
        var gp = bb.bP(this.bs, "js-txt");
        this.qx = gp[0];
        this.yW = gp[1];
        bb.gj(this.qx, "holder");
        bb.gj(this.yW, "holder");
        bj.bt(this.qx, "focus", this.KT.bi(this));
        bj.bt(this.qx, "keypress", this.KU.bi(this));
        bj.bt(this.qx, "keyup", this.KV.bi(this));
        bj.bt(this.yW, "focus", this.bNK.bi(this));
        bj.bt(this.yW, "keypress", this.bNU.bi(this));
        this.Pl = bb.bP(this.bs, "js-cd")[0];
        this.nQ = bb.bP(this.bs, "js-send")[0];
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.FQ = bb.bP(this.bs, "js-next")[0];
        this.FR = bb.bP(this.bs, "js-btmbar")[0];
        this.VR = bb.bP(this.bs, "js-back")[0];
        this.buG = bb.bP(this.bs, "js-skip")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.KT = function () {
        bb.bH(this.qx, "u-txt-err")
    };
    bc.bNK = function () {
        bb.bH(this.yW, "u-txt-err")
    };
    bc.KU = function (be) {
        if (be.keyCode == 0) {
            if (be.charCode < 48 || be.charCode > 57) bj.dp(be)
        } else if (be.charCode == 0) {
            if (be.keyCode == 13)return this.tT()
        } else {
            if (be.keyCode == 13)return this.tT();
            if (be.keyCode < 48 || be.keyCode > 57) bj.dp(be)
        }
    };
    bc.KV = function (be) {
        if (/[^\d]/.test(this.qx.value)) this.qx.value = this.qx.value.replace(/[^\d]/g, "")
    };
    bc.bNU = function (be) {
        if (be.keyCode == 13) this.tT()
    };
    bc.bR = function (bf) {
        bO.bR.apply(this, arguments);
        this.ed = bf;
        this.dh(false);
        this.dF(false);
        if (bf.tip) {
            this.dA.innerHTML = bf.tip;
            bb.bH(this.dA, "f-hide")
        } else {
            bb.bJ(this.dA, "f-hide")
        }
        this.hm = bf.mobile || "";
        if (this.hm) {
            this.hx.innerText = bn.Jd(this.hm) || "";
            bb.bJ(this.buM, "f-hide");
            bb.bH(this.buP, "f-hide");
            this.Pg()
        } else {
            this.bNJ.innerHTML = bf.mobileLabel || "手机号：";
            this.nQ.innerHTML = "<i>获取验证码</i>";
            bb.bJ(this.buP, "f-hide");
            bb.bH(this.buM, "f-hide");
            bb.bJ(this.Pl, "f-hide");
            bb.bH(this.nQ, "f-hide")
        }
        this.qx.value = "";
        this.yW.value = "";
        bf.okbutton = bf.okbutton || "下一步";
        this.FQ.innerHTML = "<i>" + bf.okbutton + "</i>";
        bb.bJ(this.FR, "f-hide");
        bb.bJ(this.VR, "f-hide");
        bb.bJ(this.buG, "f-hide");
        if (bf.backbutton) {
            this.VR.innerHTML = bf.backbutton || "";
            bb.bH(this.VR, "f-hide");
            bb.bH(this.FR, "f-hide")
        }
        if (bf.canskip) {
            bb.bH(this.buG, "f-hide");
            bb.bH(this.FR, "f-hide")
        }
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"next":
                this.tT(be);
                break;
            case"send":
                this.bOf(be);
                break;
            case"back":
                this.VX(be);
                break;
            case"skip":
                this.VY(be);
                break
        }
    };
    bc.VX = function (be) {
        bj.dp(be);
        this.cw();
        if (this.ed.onback)return this.ed.onback()
    };
    bc.VY = function (be) {
        bj.dp(be);
        this.cw();
        if (this.ed.onskip)return this.ed.onskip()
    };
    bc.bOf = function (be) {
        bj.dp(be);
        if (!!this.gl)return;
        var fS = this.FU();
        if (!fS)return;
        this.bS.Bn({data: {cellphone: fS}})
    };
    bc.wK = function (bp) {
        this.Pg()
    };
    bc.KK = function (bp) {
        this.dF(false);
        this.dh("验证码发送失败")
    };
    bc.tT = function (be) {
        bj.dp(be);
        if (this.dF())return;
        var kT = this.oY();
        if (!kT)return;
        this.dF(true);
        this.bS.bKJ({data: {cellphone: kT.mobile, captcha: kT.captcha}})
    };
    bc.bNE = function (bp) {
        if (this.ed.onok) this.ed.onok(bp)
    };
    bc.bNG = function (bp) {
        this.dF(false);
        if (bp.code == 503) {
            this.dh("验证码错误", "captcha")
        } else if (this.ed.onerror) {
            this.ed.onerror(bp)
        }
    };
    bc.FU = function () {
        var fS = this.hm || this.qx.value.trim();
        if (!fS)return this.dh("请输入手机号", "mobile");
        if (!bn.vM(fS))return this.dh("请输入11位数字的手机号", "mobile");
        return fS
    };
    bc.oY = function () {
        var fS = this.hm || this.qx.value.trim(), cmD = this.yW.value.trim();
        if (!fS)return this.dh("请输入手机号", "mobile");
        if (!cmD)return this.dh("请输入验证码", "captcha");
        if (!bn.vM(fS))return this.dh("请输入11位数字的手机号", "mobile");
        this.dh(false);
        return {mobile: fS, captcha: cmD}
    };
    bc.Pg = function () {
        var cT;
        var buA = function () {
            cT--;
            this.Pl.innerText = " 00:" + (cT >= 10 ? cT : "0" + cT) + " ";
            if (cT == 0) {
                this.gl = clearInterval(this.gl);
                this.nQ.innerHTML = "<i>重新发送</i>";
                bb.bJ(this.Pl, "f-hide");
                bb.bH(this.nQ, "f-hide")
            }
        };
        return function () {
            cT = 60;
            this.gl = clearInterval(this.gl);
            this.gl = setInterval(buA.bi(this), 1e3);
            buA.call(this);
            bb.bJ(this.nQ, "f-hide");
            bb.bH(this.Pl, "f-hide")
        }
    }();
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.qx, "u-txt-err");
        bb.bH(this.yW, "u-txt-err");
        if (iD == "mobile") {
            bb.bJ(this.qx, "u-txt-err")
        } else if (iD == "captcha") {
            bb.bJ(this.yW, "u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.FQ, dI, this.ed.okbutton, "验证中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), fc = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.zL = NEJ.C();
    bc = bo.zL.bU(fc.dZ);
    bc.cz = function (bf) {
        this.cB(bf);
        this.ed = bf;
        this.qW = bf.user;
        this.bS = bq.mA.bF();
        this.bS.bt("onmobilebind", this.Wf.bi(this));
        this.bS.bt("onmobilebinderror", this.Wg.bi(this));
        this.bS.bt("onactive", this.Lm.bi(this));
        this.bS.bt("onactiveerror", this.Wi.bi(this));
        if (bf.requiremobile && !this.bOi(this.qW)) {
            this.fD = bo.qq.bR({title: "绑定手机号", onok: this.Wl.bi(this), canskip: true, onskip: this.Pc.bi(this)})
        } else {
            this.Pc()
        }
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.fD) this.fD.bW();
        if (this.mY) this.mY.bW()
    };
    bc.Wl = function (cr) {
        this.hm = cr.mobile;
        this.OZ = cr.captcha;
        this.bS.bhy({data: {phone: this.hm, captcha: this.OZ}})
    };
    bc.Pc = function () {
        if (this.mY) this.mY.bW();
        this.mY = bo.Bb.bR({title: "设置昵称", onok: this.bOq.bi(this)})
    };
    bc.Wf = function () {
        this.fD.cw();
        this.Pc()
    };
    bc.Wg = function (cr) {
        if (cr.code == 506) {
            this.fD.dF(false);
            this.fD.dh(cr.message, "mobile")
        } else {
            this.fD.cw();
            this.Pc()
        }
    };
    bc.bOq = function (cr) {
        this.bS.bhv({data: {nickname: cr.nickname, dragPwd: cr.dragPwd}})
    };
    bc.Lm = function (cr) {
        this.mY.cw();
        this.qW.profile = cr.profile;
        bj.bK(window, "login", {user: this.qW})
    };
    bc.Wi = function (cr) {
        this.mY.dF(false);
        if (cr.code == 505)return this.mY.dh("该昵称已被占用", "nickname", true);
        if (cr.code == 407)return this.mY.dh("该昵称包含关键词", "nickname", true);
        bo.ci.bR({tip: cr.message || "登录失败，请重试", type: 2});
        this.mY.cw()
    };
    bc.bOi = function (eQ) {
        var rc = eQ.bindings || [];
        return bm.eg(rc, function (bw) {
                return bw.type == 1
            }) >= 0
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.Lv = NEJ.C();
    bc = bo.Lv.bU(bo.fz);
    bO = bo.Lv.dr;
    bc.dx = function () {
        this.dy = "ntp-reg-mobile"
    };
    bc.dm = function () {
        this.dw();
        var fx = bb.bP(this.bs, "u-txt");
        this.hx = fx[0];
        this.fk = fx[1];
        bb.gj(this.hx, "holder");
        bb.gj(this.fk, "holder");
        bj.bt(this.hx, "focus", this.KT.bi(this));
        bj.bt(this.hx, "keypress", this.KU.bi(this));
        bj.bt(this.hx, "keyup", this.KV.bi(this));
        bj.bt(this.fk, "focus", this.wZ.bi(this));
        bj.bt(this.fk, "keypress", this.wY.bi(this));
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.du = bb.bP(this.bs, "u-btn2")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.KT = function () {
        bb.bH(this.hx, "u-txt-err")
    };
    bc.wZ = function () {
        bb.bH(this.fk, "u-txt-err")
    };
    bc.KU = function (be) {
        if (be.keyCode == 0) {
            if (be.charCode < 48 || be.charCode > 57) bj.dp(be)
        } else if (be.charCode == 0) {
            if (be.keyCode == 13)return this.OV()
        } else {
            if (be.keyCode == 13)return this.OV();
            if (be.keyCode < 48 || be.keyCode > 57) bj.dp(be)
        }
    };
    bc.KV = function (be) {
        if (/[^\d]/.test(this.hx.value)) this.hx.value = this.hx.value.replace(/[^\d]/g, "")
    };
    bc.wY = function (be) {
        if (be.keyCode == 13) this.OV()
    };
    bc.bR = function (bf) {
        bO.bR.apply(this, arguments);
        this.ed = bf;
        this.dh(false);
        this.dF(false);
        this.hx.value = bf.mobile || "";
        this.fk.value = ""
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"ok":
                this.OV(be);
                break;
            case"back":
                this.VX(be);
                break
        }
    };
    bc.VX = function (be) {
        bj.dp(be);
        this.cw();
        bo.oj.bR({title: "登录"})
    };
    bc.OV = function (be) {
        bj.dp(be);
        var kT = this.oY();
        if (!kT)return;
        this.dF(true);
        if (this.ed.onok) this.ed.onok({mobile: kT.mobile, password: kT.password})
    };
    bc.oY = function () {
        var fS = this.hx.value.trim();
        var gV = this.fk.value;
        if (!fS)return this.dh("请输入手机号", "mobile");
        if (!gV)return this.dh("请输入登录密码", "password");
        if (!bn.vM(fS))return this.dh("请输入11位数字的手机号", "mobile");
        if (gV.length < 6 || gV.length > 16)return this.dh("请输入6-16位的密码", "password");
        return {mobile: fS, password: gV}
    };
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.hx, "u-txt-err");
        bb.bH(this.fk, "u-txt-err");
        if (iD == "mobile") {
            bb.bJ(this.hx, "u-txt-err")
        } else if (iD == "password") {
            bb.bJ(this.fk, "u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, "下一步", "发送中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bq = bd("nm.d"), bo = bd("nm.l"), bT = bd("nm.w"), bc, bO;
    bo.OS = NEJ.C();
    bc = bo.OS.bU(bo.fz);
    bO = bo.OS.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onmobileregist", this.LC.bi(this));
        this.bS.bt("onmobileregisterror", this.jv.bi(this))
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
    };
    bc.dx = function () {
        this.dy = "ntp-reg-setting"
    };
    bc.dm = function () {
        this.dw();
        this.dA = bb.bP(this.bs, "js-tip")[0];
        this.iF = bb.bP(this.bs, "js-input")[0];
        bb.gj(this.iF, "holder");
        bj.bt(this.iF, "focus", this.bOr.bi(this));
        bj.bt(this.iF, "keypress", this.bOs.bi(this));
        bj.bt(this.iF, "keyup", this.Vn.bi(this));
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.du = bb.bP(this.bs, "js-primary")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.bR = function (bf) {
        bO.bR.apply(this, arguments);
        this.hm = bf.mobile || "";
        this.qE = bf.password || "";
        this.bOv = bf.captcha || "";
        if (bf.tip) {
            this.dA.innerHTML = bf.tip
        }
        this.dh(false);
        this.dF(false);
        this.iF.value = ""
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"ok":
                this.LG(be);
                break
        }
    };
    bc.bOr = function () {
        bb.bH(this.iF, "u-txt-err")
    };
    bc.bOs = function (be) {
        if (be.keyCode == 13) this.LG()
    };
    bc.LG = function (be) {
        bj.dp(be);
        if (this.dF())return;
        var kT = this.oY();
        if (!kT)return;
        var bl = {phone: this.hm, password: bm.lB(this.qE), nickname: kT.nickname, captcha: this.bOv};
        this.dF(true);
        this.bS.Qu({data: bl})
    };
    bc.LC = function (bp) {
        this.dF(false);
        this.cw();
        localCache.sq("user", bp);
        bj.bK(window, "login", {user: bp})
    };
    bc.jv = function (cr) {
        this.dF(false);
        if (cr.code == 415) {
            if (this.dn) {
                this.dn.bW();
                this.dh("注册过于频繁", "captcha")
            }
            this.dn = bT.Fm.bF({captchaId: cr.captchaId, txt: "txt-login-captcha", onaction: this.LG.bi(this)});
            this.fO.insertAdjacentElement("beforeBegin", this.dn.mL());
            return
        }
        if (cr.code == 505)return this.dh("该昵称已被占用", "nickname");
        if (cr.code == 407)return this.dh("该昵称包含关键词", "nickname");
        if (cr.message) {
            this.dh(cr.message)
        } else {
            bo.ci.bR({tip: "注册失败，请重试", type: 2})
        }
    };
    bc.oY = function () {
        var iU = this.iF.value.trim(), cmK = iU.replace(/[^\x00-\xff]/g, "**"), cmD = "";
        if (!iU)return this.dh("请输入昵称", "nickname");
        if (this.dn) {
            cmD = this.dn.gn();
            if (!cmD)return this.dh("请输入验证码", "captcha");
            var cP = this.dn.xf();
            if (!cP.success) {
                return this.dh(cP.message, "captcha")
            }
        }
        if (cmK.length < 4 || cmK.length > 30)return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        if (!/^[\u4e00-\u9fa5A-Za-z0-9-_]*$/.test(iU))return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        return {nickname: iU, captcha: cmD}
    };
    bc.Vn = function (be) {
        var iU = this.iF.value.trim(), cmK = iU.replace(/[^\x00-\xff]/g, "**");
        if (this.Vu == iU)return;
        this.Vu = iU;
        if (be.keyCode == 13)return;
        if (/[^\u4e00-\u9fa5\w-]/.test(iU))return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        if (iU && cmK.length > 30)return this.dh("昵称应该是4-30个字，且不包含除-和_以外的特殊字符", "nickname");
        this.dh(false)
    };
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.iF, "u-txt-err");
        if (this.dn) this.dn.bH("u-txt-err");
        if (iD == "nickname") {
            bb.bJ(this.iF, "u-txt-err")
        } else if (iD == "captcha") {
            if (this.dn) this.dn.bJ("u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, "开启云音乐", "设置中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), fc = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    var MOB_CHECK = {MAIN: 1, SNS: 2, NETEASE: 3, NULL: -1};
    bo.OO = NEJ.C();
    bc = bo.OO.bU(fc.dZ);
    bc.cz = function (bf) {
        bf = bf || {};
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onsendcaptcha", this.wK.bi(this));
        this.bS.bt("onsendcaptchaerror", this.WH.bi(this));
        this.bS.bt("onmobilecheck", this.LI.bi(this));
        this.bS.bt("onmobilecheckerror", this.LJ.bi(this));
        this.bS.bt("onmobileregist", this.LC.bi(this));
        this.bS.bt("onmobileregisterror", this.ON.bi(this));
        this.wX = bo.Lv.bR({title: "手机号注册", onok: this.WM.bi(this)})
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.wX) this.wX.bW();
        if (this.fD) this.fD.bW()
    };
    bc.WM = function (cr) {
        this.hm = cr.mobile;
        this.qE = cr.password;
        this.bS.Bn({data: {cellphone: cr.mobile}})
    };
    bc.wK = function () {
        this.wX.cw();
        this.fD = bo.qq.bR({
            title: "手机号注册",
            mobile: this.hm,
            okbutton: "下一步",
            onok: this.WN.bi(this),
            backbutton: "&lt;&nbsp;&nbsp;返回登录",
            onback: this.WO.bi(this)
        })
    };
    bc.WH = function (cr) {
        this.wX.dF(false);
        bo.ci.bR({tip: cr.message || "验证码发送失败", type: 2})
    };
    bc.WN = function (cr) {
        this.hm = cr.mobile;
        this.dn = cr.captcha;
        this.bS.bhq({data: {cellphone: cr.mobile, captcha: cr.captcha}})
    };
    bc.LI = function (cr) {
        this.fD.cw();
        switch (cr.exist) {
            case MOB_CHECK.NULL:
                bo.OS.bR({title: "手机号注册", mobile: this.hm, password: this.qE, captcha: this.dn});
                break;
            case MOB_CHECK.MAIN:
            case MOB_CHECK.SNS:
            case MOB_CHECK.NETEASE:
                this.RZ(this.hm, this.qE, this.dn);
                break
        }
    };
    bc.LJ = function (cr) {
        bo.ci.bR({tip: cr.message || "验证码发送失败", type: 2})
    };
    bc.LC = function (cr) {
        localCache.sq("user", cr);
        if (!cr.profile) {
            if (this.nf) this.nf.bW();
            this.nf = bo.zL.bF({user: cr, requiremobile: false, onsuccess: this.wT.bi(this)})
        } else {
            bn.gz({
                clazz: "m-layer-w2",
                title: "手机号注册",
                message: '该手机号已与云音乐帐号 <strong class="s-fc1">' + bm.fd(cr.profile.nickname) + "</strong> 绑定，<br/><br/>以后你可以直接用该手机号+密码登录",
                btntxt: "知道了",
                action: bj.bK.bi(bj, window, "login", {user: cr}),
                onclose: bj.bK.bi(bj, window, "login", {user: cr})
            })
        }
    };
    bc.wT = function (be) {
        bj.bK(window, "login", {user: be.user})
    };
    bc.ON = function (cr) {
        if (cr.code == 415) {
            bn.bwy({captchaId: cr.captchaId, ondestroy: this.RZ.bi(this, this.hm, this.qE, this.dn)})
        } else {
            bo.ci.bR({tip: cr.message || "注册失败，请重试", type: 2})
        }
    };
    bc.WO = function () {
        this.fD.cw();
        bo.oj.bR({title: "登录"})
    };
    bc.RZ = function (fS, gV, cmD) {
        this.bS.Qu({data: {phone: fS, password: bm.lB(gV), captcha: cmD}})
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), fc = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    var MOB_CHECK = {MAIN: 1, SNS: 2, NETEASE: 3, NULL: -1};
    bo.bun = NEJ.C();
    bc = bo.bun.bU(fc.dZ);
    bc.cz = function (bf) {
        bf = bf || {};
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onsendcaptcha", this.wK.bi(this));
        this.bS.bt("onsendcaptchaerror", this.WH.bi(this));
        this.bS.bt("onmobilecheck", this.LI.bi(this));
        this.bS.bt("onmobilecheckerror", this.LJ.bi(this));
        this.bS.bt("onmobileregist", this.LC.bi(this));
        this.bS.bt("onmobileregisterror", this.ON.bi(this));
        this.wX = bo.Lv.bR({title: "重设密码", mobile: bf.mobile || "", onok: this.WM.bi(this)})
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.wX) this.wX.bW();
        if (this.fD) this.fD.bW()
    };
    bc.WM = function (cr) {
        this.hm = cr.mobile;
        this.qE = cr.password;
        this.bS.Bn({data: {cellphone: cr.mobile}})
    };
    bc.wK = function () {
        this.wX.cw();
        this.fD = bo.qq.bR({
            title: "重设密码",
            mobile: this.hm,
            okbutton: "下一步",
            onok: this.WN.bi(this),
            backbutton: "&lt;&nbsp;&nbsp;返回登录",
            onback: this.WO.bi(this),
            onerror: this.ON.bi(this)
        })
    };
    bc.WH = function (cr) {
        this.wX.dF(false);
        bo.ci.bR({tip: cr.message || "验证码发送失败", type: 2})
    };
    bc.WN = function (cr) {
        this.hm = cr.mobile;
        this.dn = cr.captcha;
        this.bS.bhq({data: {cellphone: cr.mobile, captcha: cr.captcha}})
    };
    bc.LI = function (cr) {
        this.fD.cw();
        switch (cr.exist) {
            case MOB_CHECK.NULL:
                bo.OS.bR({
                    title: "设置昵称",
                    tip: "该手机号尚未注册，取一个昵称，马上开通",
                    mobile: this.hm,
                    password: this.qE,
                    captcha: this.dn
                });
                break;
            case MOB_CHECK.MAIN:
            case MOB_CHECK.SNS:
            case MOB_CHECK.NETEASE:
                this.bS.Qu({data: {phone: this.hm, password: bm.lB(this.qE), captcha: this.dn}});
                break
        }
    };
    bc.LJ = function (cr) {
        bo.ci.bR({tip: cr.message || "验证码发送失败", type: 2})
    };
    bc.WO = function () {
        this.fD.cw();
        bo.oj.bR({title: "登录"})
    };
    bc.LC = function (bp) {
        localCache.sq("user", bp);
        if (!bp.profile) {
            if (this.nf) this.nf.bW();
            this.nf = bo.zL.bF({user: bp, requiremobile: false, onsuccess: this.wT.bi(this)})
        } else {
            bj.bK(window, "login", {user: bp})
        }
    };
    bc.wT = function (be) {
        bj.bK(window, "login", {user: be.user})
    };
    bc.ON = function (bp) {
        if (bp.code == 415) {
            bn.bwy({
                captchaId: bp.captchaId, ondestroy: function () {
                    this.bS.Qu({data: {phone: this.hm, password: bm.lB(this.qE), captcha: this.dn}})
                }.bi(this)
            })
        } else {
            bo.ci.bR({tip: "重设密码失败，请重试", type: 2})
        }
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bT = bd("nm.w"), bc, bO;
    bo.Bv = NEJ.C();
    bc = bo.Bv.bU(bo.fz);
    bO = bo.Bv.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onmobilelogin", this.Bs.bi(this));
        this.bS.bt("onmobileloginerror", this.jv.bi(this))
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
        if (this.uh) this.uh.bW()
    };
    bc.dx = function () {
        this.dy = "ntp-login-mobile"
    };
    bc.dm = function () {
        this.dw();
        var gp = bb.bP(this.bs, "js-input");
        this.hx = gp[0];
        this.fk = gp[1];
        bb.gj(this.hx, "holder");
        bb.gj(this.fk, "holder");
        bj.bt(this.hx, "focus", this.KT.bi(this));
        bj.bt(this.hx, "keypress", this.KU.bi(this));
        bj.bt(this.hx, "keyup", this.KV.bi(this));
        bj.bt(this.fk, "focus", this.wZ.bi(this));
        bj.bt(this.fk, "keypress", this.wY.bi(this));
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.LS = bb.bP(this.bs, "u-auto")[0];
        this.du = bb.bP(this.bs, "js-primary")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.bR = function () {
        bO.bR.apply(this, arguments);
        this.dh(false);
        this.dF(false);
        this.hx.value = "";
        this.fk.value = "";
        this.LS.checked = true
    };
    bc.KT = function () {
        bb.bH(this.hx, "u-txt-err")
    };
    bc.wZ = function () {
        bb.bH(this.fk, "u-txt-err")
    };
    bc.KU = function (be) {
        if (be.keyCode == 0) {
            if (be.charCode < 48 || be.charCode > 57) bj.dp(be)
        } else if (be.charCode == 0) {
            if (be.keyCode == 13)return this.iX()
        } else {
            if (be.keyCode == 13)return this.iX();
            if (be.keyCode < 48 || be.keyCode > 57) bj.dp(be)
        }
    };
    bc.KV = function (be) {
        if (/[^\d]/.test(this.hx.value)) this.hx.value = this.hx.value.replace(/[^\d]/g, "")
    };
    bc.wY = function (be) {
        if (be.keyCode == 13) this.iX()
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"login":
                this.iX(be);
                break;
            case"forget":
                bj.cu(be);
                this.cw();
                bo.bun.bF({mobile: this.hx.value});
                break;
            case"select":
                this.WY(be);
                break;
            case"reg":
                this.bOE(be);
                break
        }
    };
    bc.iX = function (be) {
        bj.dp(be);
        if (this.dF())return;
        var kT = this.oY();
        if (!kT)return;
        if (!this.LV())return;
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
        var bl = {phone: kT.mobile, password: bm.lB(kT.password), rememberLogin: this.LS.checked};
        this.dF(true);
        this.dh(false);
        this.bS.bKK({data: bl})
    };
    bc.Bs = function (bp) {
        this.dF(false);
        this.cw();
        localCache.sq("user", bp);
        if (!bp.profile) {
            if (this.nf) this.nf.bW();
            this.nf = bo.zL.bF({user: bp, requiremobile: false, onsuccess: this.wT.bi(this)})
        } else {
            bj.bK(window, "login", {user: bp})
        }
    };
    bc.wT = function (be) {
        bj.bK(window, "login", {user: be.user})
    };
    bc.jv = function (cr) {
        this.dF(false);
        if (cr.code == 415) {
            if (this.dn) this.dn.bW();
            this.dn = bT.Fm.bF({captchaId: cr.captchaId, txt: "txt-login-captcha", onaction: this.iX.bi(this)});
            this.fO.insertAdjacentElement("beforeBegin", this.dn.mL());
            return
        }
        if (cr.code == 501) {
            this.dh("该手机号尚未注册", "mobile");
            return
        }
        if (cr.code == 10002 || cr.code == 502 || cr.code == 501) {
            this.dh("手机号或密码错误");
            return
        }
        if (cr.message) {
            this.dh(cr.message)
        } else {
            bo.ci.bR({tip: "登录失败，请重试", type: 2})
        }
    };
    bc.WY = function (be) {
        bj.cu(be);
        bo.oj.bR({title: "登录"})
    };
    bc.bOE = function (be) {
        bj.cu(be);
        this.cw();
        if (this.uh) this.uh.bW();
        this.uh = bo.OO.bF()
    };
    bc.oY = function () {
        var fS = this.hx.value.trim();
        var gV = this.fk.value;
        if (!fS)return this.dh("请输入手机号", "mobile");
        if (!gV)return this.dh("请输入登录密码", "password");
        if (!bn.vM(fS))return this.dh("请输入11位数字的手机号", "mobile");
        return {mobile: fS, password: gV}
    };
    bc.LV = function () {
        if (!this.dn)return true;
        var cP = this.dn.xf();
        if (cP.success)return true;
        this.dh(cP.message, "captcha");
        return false
    };
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.hx, "u-txt-err");
        bb.bH(this.fk, "u-txt-err");
        if (this.dn) this.dn.bH("u-txt-err");
        if (iD == "mobile") {
            bb.bJ(this.hx, "u-txt-err")
        } else if (iD == "password") {
            bb.bJ(this.fk, "u-txt-err")
        } else if (iD == "captcha") {
            if (this.dn) this.dn.bJ("u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, "登　录", "登录中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), ej = bd("nej.p"), bM = bd("nej.ut"), oH, bOF;
    if (!!bM.Bd)return;
    bM.Bd = NEJ.C();
    oH = bM.Bd.bU(bM.dZ);
    bOF = bM.Bd.dr;
    oH.cz = function (bf) {
        this.cB(bf);
        this.bs = bb.bG(bf.body);
        this.eP = bb.bG(bf.input);
        this.kj = bf.selected || "js-selected";
        this.dR = 0;
        this.dq([[this.eP, "input", this.iy.bi(this)], [this.eP, "blur", this.Xe.bi(this, "blur")], [this.bs, "mouseover", this.Bz.bi(this)], [this.bs, "click", this.gB.bi(this)], [document, "keydown", this.bOH.bi(this)], [document, "keypress", this.Xg.bi(this)]]);
        if (ej.ek.release == "5.0") {
            this.dq([[this.eP, "keydown", this.buf.bi(this)], [this.eP, "keyup", this.buf.bi(this)]])
        }
    };
    oH.cR = function () {
        this.cV();
        this.bue();
        delete this.kj;
        delete this.eP;
        delete this.bs;
        delete this.bud;
        delete this.Xk
    };
    oH.bOI = function (bC) {
        return bC.flag != null
    };
    oH.bue = function () {
        var bOM = function (bh) {
            bm.NB(bh, "flag")
        };
        return function () {
            bm.cv(this.dK, bOM);
            delete this.dK;
            delete this.dR
        }
    }();
    oH.Xn = function (bv) {
        if (this.dR === bv)return;
        this.dR = bv;
        bb.bJ(this.dK[this.dR], this.kj)
    };
    oH.btX = function (bv) {
        if (this.dR !== bv)return;
        bb.bH(this.dK[this.dR], this.kj);
        delete this.dR
    };
    oH.Xe = function (bu) {
        this.Xp = setTimeout(function () {
            if (!this.dK)return;
            var bw = this.dK[this.dR] || this.dK[0], bD = bb.bz(bw, "value") || bw.innerText;
            this.eP.value = bD;
            this.qY();
            this.Xk = !0;
            this.bK("onselect", bD, {type: bu});
            this.Xk = !1
        }.bi(this), bu == "blur" ? 200 : 0)
    };
    oH.iy = function () {
        var bD = this.eP.value.trim();
        if (!bD) {
            this.qY()
        } else {
            if (this.Xk)return;
            this.bK("onchange", bD)
        }
    };
    oH.Bz = function (be) {
        var bC = bj.bY(be, this.bOI);
        if (!!bC) {
            this.btX(this.dR);
            this.Xn(bC.flag)
        }
    };
    oH.gB = function () {
        if (this.Xp) {
            this.Xp = clearTimeout(this.Xp)
        }
        this.Xe("click")
    };
    oH.bOH = function (be) {
        var fI = 0, dX = be.keyCode;
        if (dX == 38) fI = -1;
        if (dX == 40) fI = 1;
        if (!fI)return;
        bj.cu(be);
        var bv = Math.max(0, Math.min(this.dR + fI, this.dK.length - 1));
        if (bv === this.dR)return;
        this.btX(this.dR);
        this.Xn(bv)
    };
    oH.Xg = function (be) {
        var bu = "enter";
        if (be.keyCode == 13) this.Xe(bu)
    };
    oH.buf = function (be) {
        if (be.type == "keydown") {
            this.bud = this.eP.value
        } else if (this.bud != this.eP.value && !!this.dK) {
            this.iy()
        }
    };
    oH.qY = function () {
        var bOS = function (bh, bv) {
            bh.flag = bv
        };
        return function (bk) {
            this.bue();
            if (!bk || !bk.length) {
                this.bs.style.visibility = "hidden";
                return this
            }
            this.dK = bk;
            var bv = bm.eg(this.dK, function (bh) {
                return bb.cU(bh, this.kj)
            });
            this.Xn(Math.max(0, bv));
            bm.cv(this.dK, bOS);
            this.bs.style.visibility = "visible";
            return this
        }
    }()
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bI = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), bo = bd("nm.l"), bc, bO;
    bo.Ar = NEJ.C();
    bc = bo.Ar.bU(bo.fz);
    bO = bo.Ar.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.bS = bq.mA.bF();
        this.bS.bt("onlogin", this.Bs.bi(this));
        this.bS.bt("onloginerror", this.jv.bi(this))
    };
    bc.cR = function () {
        this.cV();
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
    };
    bc.dx = function () {
        this.dy = "ntp-login-netease"
    };
    bc.dm = function () {
        this.dw();
        var gp = bb.bP(this.bs, "js-input");
        this.iF = gp[0];
        this.fk = gp[1];
        bb.gj(this.iF, "holder");
        bb.gj(this.fk, "holder");
        bj.bt(this.iF, "focus", this.Xt.bi(this));
        bj.bt(this.fk, "focus", this.wZ.bi(this));
        bj.bt(this.fk, "keypress", this.wY.bi(this));
        this.tm = bb.bP(this.bs, "js-suggest")[0];
        this.ts = bI.Bd.bF({body: this.tm, input: this.iF, onchange: this.Ai.bi(this), onselect: this.Ag.bi(this)});
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.LS = bb.bP(this.bs, "u-auto")[0];
        this.du = bb.bP(this.bs, "js-primary")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.bR = function () {
        bO.bR.apply(this, arguments);
        this.dh(false);
        this.dF(false);
        this.iF.value = "";
        this.fk.value = "";
        this.LS.checked = true
    };
    bc.Xt = function () {
        bb.bH(this.iF, "u-txt-err")
    };
    bc.wZ = function () {
        bb.bH(this.fk, "u-txt-err")
    };
    bc.wY = function (be) {
        if (be.keyCode == 13) this.iX()
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"login":
                this.iX(be);
                break;
            case"suggest":
                this.Xy(be);
                break;
            case"select":
                this.WY(be);
                break
        }
    };
    bc.Xy = function (be) {
        var bh = bj.bY(be);
        if (bh.href) {
            bj.dp(be)
        }
    };
    bc.Ai = function (bD) {
        if (!bD)return this.ts.qY([]);
        var kA = ["163.com", "126.com", "yeah.net", "vip.163.com", "vip.126.com", "188.com"];
        var jr = bD.indexOf("@"), i, iQ;
        if (jr < 0) {
            for (i = 0, iQ = []; i < kA.length; ++i) {
                iQ.push(bD + "@" + kA[i])
            }
        } else {
            var qJ = bD.substring(jr + 1), cF = qJ.length;
            for (i = 0, iQ = []; i < kA.length; ++i) {
                if (kA[i].substr(0, cF) == qJ) {
                    iQ.push(bD.substring(0, jr) + "@" + kA[i])
                }
            }
        }
        this.tm.innerHTML = bb.dg("jst-login-suggest", {suggests: iQ}, {escape: bm.fd});
        this.ts.qY(bb.eu(this.tm))
    };
    bc.Ag = function (bD) {
        this.iF.value = bD;
        this.fk.focus()
    };
    bc.iX = function (be) {
        bj.dp(be);
        if (this.dF())return;
        var kT = this.oY();
        if (!kT)return;
        if (!this.LV())return;
        if (this.dn) {
            this.dn.bW();
            delete this.dn
        }
        var bl = {username: kT.username, password: bm.lB(kT.password), rememberLogin: this.LS.checked};
        this.dF(true);
        this.dh(false);
        this.bS.bwT({data: bl})
    };
    bc.Bs = function (bp) {
        this.dF(false);
        this.cw();
        localCache.sq("user", bp);
        if (!bp.profile) {
            if (this.nf) this.nf.bW();
            this.nf = bo.zL.bF({user: bp, requiremobile: false, onsuccess: this.wT.bi(this)})
        } else {
            bj.bK(window, "login", {user: bp})
        }
    };
    bc.wT = function (be) {
        bj.bK(window, "login", {user: be.user})
    };
    bc.jv = function (cr) {
        this.dF(false);
        if (cr.code == 415) {
            if (this.dn) this.dn.bW();
            this.dn = bT.Fm.bF({captchaId: cr.captchaId, txt: "txt-login-captcha", onaction: this.iX.bi(this)});
            this.fO.insertAdjacentElement("beforeBegin", this.dn.mL());
            return
        }
        if (cr.code == 10002 || cr.code == 502 || cr.code == 501) {
            this.dh("帐号或密码错误");
            return
        }
        if (cr.message) {
            this.dh(cr.message)
        } else {
            bo.ci.bR({tip: "登录失败，请重试", type: 2})
        }
    };
    bc.WY = function (be) {
        bj.cu(be);
        bo.oj.bR({title: "登录"})
    };
    bc.oY = function () {
        var lX = this.iF.value.trim(), gV = this.fk.value;
        if (!lX) {
            this.dh("请输入邮箱帐号", "username");
            return null
        }
        if (!gV) {
            this.dh("请输入登录密码", "password");
            return null
        }
        this.dh(false);
        return {username: lX, password: gV}
    };
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.iF, "u-txt-err");
        bb.bH(this.fk, "u-txt-err");
        if (this.dn) this.dn.bH("u-txt-err");
        if (iD == "username") {
            bb.bJ(this.iF, "u-txt-err")
        } else if (iD == "password") {
            bb.bJ(this.fk, "u-txt-err")
        } else if (iD == "captcha") {
            if (this.dn) this.dn.bJ("u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, "登　录", "登录中...")
    };
    bc.LV = function () {
        if (!this.dn)return true;
        var cP = this.dn.xf();
        if (cP.success)return true;
        this.dh(cP.message, "captcha");
        return false
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.oj = NEJ.C();
    bc = bo.oj.bU(bo.fz);
    bc.dx = function () {
        this.dy = "ntp-login-nav"
    };
    bc.dm = function () {
        this.dw();
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action"), bu = bb.bz(bC, "type");
        this.cw();
        switch (cl) {
            case"login":
                if (bu == "mobile") {
                    bj.cu(be);
                    bo.Bv.bR({title: "手机号登录"})
                } else if (bu == "netease") {
                    bo.Ar.bR({title: "邮箱登录"})
                }
                break;
            case"reg":
                bj.cu(be);
                if (this.uh) this.uh.bW();
                this.uh = bo.OO.bF();
                break
        }
    };
    bo.oj.bR = bo.oj.bR.fj(function (be) {
        bo.Bv.cw();
        bo.Ar.cw()
    })
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bq = bd("nm.d"), bo = bd("nm.l"), bn = bd("nm.x"), bc, bO;
    bo.Gr = NEJ.C();
    bc = bo.Gr.bU(bo.fz);
    bO = bo.Gr.dr;
    bc.dx = function () {
        this.dy = "ntp-setpassword"
    };
    bc.dm = function () {
        this.dw();
        var XD = bb.bP(this.bs, "js-tip");
        this.dA = XD[0];
        this.btU = XD[1];
        this.btS = XD[2];
        this.hx = bb.bP(this.bs, "js-mob")[0];
        this.fk = bb.bP(this.bs, "js-input")[0];
        bb.gj(this.fk, "holder");
        bj.bt(this.fk, "focus", this.gI.bi(this));
        bj.bt(this.fk, "keypress", this.KB.bi(this));
        this.fO = bb.bP(this.bs, "u-err")[0];
        this.du = bb.bP(this.bs, "js-primary")[0];
        this.FR = bb.bP(this.bs, "js-btmbar")[0];
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.ed = bf;
        this.dh(false);
        this.dF(false);
        if (bf.tip) {
            this.dA.innerHTML = bf.tip;
            bb.bH(this.dA, "f-hide")
        } else {
            bb.bJ(this.dA, "f-hide")
        }
        if (bf.mobile) {
            this.hx.innerHTML = bn.Jd(bf.mobile) || "";
            bb.bJ(this.btS, "f-hide");
            bb.bH(this.btU, "f-hide")
        } else {
            bb.bJ(this.btU, "f-hide");
            bb.bH(this.btS, "f-hide")
        }
        this.fk.value = "";
        bf.okbutton = bf.okbutton || "下一步";
        this.du.innerHTML = "<i>" + bf.okbutton + "</i>";
        if (bf.canskip) {
            bb.bH(this.FR, "f-hide")
        } else {
            bb.bJ(this.FR, "f-hide")
        }
    };
    bc.cS = function (be) {
        var bC = bj.bY(be, "d:action");
        if (!bC)return;
        var cl = bb.bz(bC, "action");
        switch (cl) {
            case"ok":
                this.yu(be);
                break;
            case"skip":
                this.VY(be);
                break
        }
    };
    bc.gI = function () {
        bb.bH(this.fk, "u-txt-err")
    };
    bc.KB = function (be) {
        if (be.keyCode == 13) this.yu()
    };
    bc.VY = function (be) {
        bj.dp(be);
        this.cw();
        if (this.ed.onskip) this.ed.onskip()
    };
    bc.yu = function (be) {
        bj.dp(be);
        if (this.dF())return;
        var gV;
        if (!(gV = this.XG()))return;
        this.dF(true);
        if (this.ed.onok) this.ed.onok({password: gV, mobile: this.ed.mobile})
    };
    bc.XG = function () {
        var gV = this.fk.value;
        if (!gV)return this.dh("请输入密码", "password");
        if (gV.length < 6 || gV.length > 16)return this.dh("请输入6-16位的密码", "password");
        if (/[^\x00-\xff]/.test(gV))return this.dh("密码不支持中文字符", "password");
        return gV
    };
    bc.dh = function (cZ, iD) {
        this.eH(this.fO, cZ);
        bb.bH(this.fk, "u-txt-err");
        if (iD == "password") {
            bb.bJ(this.fk, "u-txt-err")
        }
    };
    bc.dF = function (dI) {
        return this.eU(this.du, dI, this.ed.okbutton, "设置中...")
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), fc = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.btL = NEJ.C();
    bc = bo.btL.bU(fc.dZ);
    var MOB_CHECK = {MAIN: 1, SNS: 2, NETEASE: 3, NULL: -1};
    var ACCOUNT_TYPE = {MOBILE: 1, TWEIBO: 6};
    var LOGIN_ACCOUNT = [{type: 1, title: "手机", key: "cellphone"}, {type: 0, title: "网易邮箱帐号", key: "email"}, {
        type: 2,
        title: "新浪微博",
        key: "name"
    }, {type: 10, title: "微信", key: "nickname"}, {type: 5, title: "QQ", key: "nickname"}];
    bc.cz = function (bf) {
        this.cB(bf);
        this.ed = bf;
        this.qW = bf.user;
        this.bS = bq.mA.bF();
        this.bS.bt("onmobilecheck", this.LI.bi(this));
        this.bS.bt("onmobilecheckerror", this.LJ.bi(this));
        this.bS.bt("onmobilebind", this.Gu.bi(this));
        this.bS.bt("onmobilebinderror", this.Gv.bi(this));
        this.bS.bt("onmobileupdatepwd", this.Gu.bi(this));
        this.bS.bt("onmobileupdatepwderror", this.Gv.bi(this));
        this.bS.bt("onactive", this.Lm.bi(this));
        this.bS.bt("onactiveerror", this.Wi.bi(this));
        var Or = this.bPh(this.qW);
        this.btF = Or;
        this.btA = this.bPr(this.qW);
        if (bf.user.account.type == ACCOUNT_TYPE.MOBILE || bf.user.account.type == ACCOUNT_TYPE.TWEIBO) {
            if (!Or) {
                this.bPy()
            } else {
                if (Or.hasPassword) {
                    this.btq()
                } else {
                    this.btp({
                        tip: '云音乐将不再支持 <strong class="s-fc1">腾讯微博</strong> 登录方式，<br/>设置登录密码，以后可以使用手机号登录',
                        mobile: Or.uid
                    })
                }
            }
        } else {
            this.btq()
        }
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.fD) this.fD.bW();
        if (this.mY) this.mY.bW();
        if (this.lS) this.lS.bW()
    };
    bc.btq = function () {
        var cE = {
            0: "邮箱帐号",
            1: "手机号",
            2: "新浪微博",
            5: "QQ",
            10: "微信"
        }, eQ  = this.qW, Ok = this.btA.type == ACCOUNT_TYPE.TWEIBO ? this.btF : this.btA;
        if (!eQ.profile) {
            if (this.nf) this.nf.bW();
            this.nf = bo.zL.bF({user: eQ, requiremobile: false, onsuccess: this.wT.bi(this)})
        } else {
            bn.iu({
                title: "提示",
                message: "云音乐即将不支持腾讯微博登录<br/>建议你后续使用以下绑定的" + (cE[Ok.type] || "帐号") + "登录<br/><strong>" + (Ok.type == ACCOUNT_TYPE.MOBILE ? bn.Jd(Ok.uid) : bm.fd(Ok.uid)) + "</strong>",
                btnok: "查看详情",
                btncc: "知道了",
                okstyle: "u-btn2-w1",
                ccstyle: "u-btn2-w1",
                action: function (bu) {
                    if (bu == "ok") {
                        location.hash = "/user/binding/#/list"
                    } else {
                        bj.bK(window, "login", {user: eQ})
                    }
                },
                onclose: bj.bK.bi(bj, window, "login", {user: eQ})
            })
        }
    };
    bc.wT = function (be) {
        bj.bK(window, "login", {user: be.user})
    };
    bc.bPy = function () {
        this.fD = bo.qq.bR({
            title: "绑定手机号",
            tip: '云音乐将不再支持 <strong class="s-fc1">腾讯微博</strong> 登录方式，<br/>请绑定手机号，以免后续无法使用该帐号',
            onok: this.bPR.bi(this)
        })
    };
    bc.bPR = function (cr) {
        this.hm = cr.mobile;
        this.OZ = cr.captcha;
        this.bS.bhq({data: {cellphone: cr.mobile, captcha: cr.captcha}})
    };
    bc.LI = function (cr) {
        if (cr.nickname) {
            this.fD.dF(false);
            this.fD.dh("绑定失败，该手机号已与云音乐帐号 " + bm.fd(cr.nickname) + " 绑定", "mobile")
        } else {
            this.btp()
        }
    };
    bc.LJ = function () {
        this.fD.cw();
        bo.ci.bR({tip: "登录失败，请重试", type: 2})
    };
    bc.btp = function (cX) {
        if (this.fD) this.fD.cw();
        cX = cX || {};
        this.lS = bo.Gr.bR({title: "设置密码", tip: cX.tip, mobile: cX.mobile, onok: this.bPS.bi(this)})
    };
    bc.bPS = function (cr) {
        if (this.btF) {
            this.bS.Qt({data: {phone: this.hm, password: bm.lB(cr.password), captcha: this.OZ}})
        } else {
            this.bS.bhy({data: {phone: this.hm, captcha: this.OZ, password: bm.lB(cr.password)}})
        }
    };
    bc.Gu = function (cr) {
        this.lS.cw();
        if (this.qW.profile || this.qW.account.type == ACCOUNT_TYPE.MOBILE) {
            bj.bK(window, "login", {user: this.qW})
        } else if (this.qW.account.type == ACCOUNT_TYPE.TWEIBO) {
            this.mY = bo.Bb.bR({title: "设置昵称", onok: this.bPT.bi(this)})
        }
    };
    bc.Gv = function (cr) {
        this.lS.cw();
        bo.ci.bR({tip: cr.message || "登录失败，请重试", type: 2})
    };
    bc.bPT = function (cr) {
        this.bS.bhv({data: {dragPwd: cr.dragPwd, nickname: cr.nickname}})
    };
    bc.Lm = function (cr) {
        this.mY.cw();
        this.qW.profile = cr.profile;
        bj.bK(window, "login", {user: this.qW})
    };
    bc.Wi = function (cr) {
        this.mY.dF(false);
        if (cr.code == 505)return this.mY.dh("该昵称已被占用", "nickname");
        if (cr.code == 407)return this.mY.dh("该昵称包含关键词", "nickname");
        this.mY.cw();
        bo.ci.bR({tip: cr.message || "登录失败，请重试", type: 2})
    };
    bc.bPh = function (eQ) {
        var rc = eQ.bindings || [];
        var bv = bm.eg(rc, function (bw) {
            return bw.type == ACCOUNT_TYPE.MOBILE
        });
        var nh = bv >= 0 ? rc[bv] : null;
        if (!nh)return null;
        var ki = JSON.parse(nh.tokenJsonStr);
        nh.uid = ki.cellphone;
        nh.hasPassword = ki.hasPassword;
        return nh
    };
    bc.bPr = function (eQ) {
        var rc = eQ.bindings || [];
        var bv = bm.eg(rc, function (bw) {
            return bw.type == eQ.account.type
        });
        var nh = bv >= 0 ? rc[bv] : null;
        if (!nh)return null;
        var ki = JSON.parse(nh.tokenJsonStr);
        nh.uid = ki.cellphone || ki.email || ki.name || ki.nickname || "";
        return nh
    }
})();
(function () {
    var bd = NEJ.P, bI = bd("nej.ut"), bj = bd("nej.v"), bA = bd("nej.j"), bb = bd("nej.e"), bm = bd("nej.u"), bQ = bd("nm.m"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bQ.Oi = NEJ.C();
    bc = bQ.Oi.bU(bI.dZ);
    var LOGIN_ACCOUNT = [{type: 1, title: "手机", icon: "mb", key: "cellphone", uidkey: "cellphone"}, {
        type: 10,
        title: "微信",
        icon: "wx",
        key: "nickname",
        uidkey: "unionid"
    }, {type: 5, title: "QQ", icon: "qq", key: "nickname", uidkey: "openid"}, {
        type: 2,
        title: "新浪微博",
        icon: "sn",
        key: "name",
        uidkey: "uid"
    }, {type: 0, title: "网易邮箱帐号", icon: "urs", key: "email", uidkey: "email"}];
    var SHARE_ACCOUNT = [{type: 4, title: "人人", icon: "rr", key: "user.name", uidkey: "user.id"}, {
        type: 3,
        title: "豆瓣",
        icon: "db",
        key: "douban_user_name",
        uidkey: "douban_user_id"
    }];
    var TWEIBO = {type: 6, title: "腾讯微博", icon: "tc", key: "nick", uidkey: "openId"};
    var ALL_ACCOUNT = LOGIN_ACCOUNT.concat(SHARE_ACCOUNT, TWEIBO);
    bc.dv = function (bf) {
        this.dC(bf);
        window.login = this.bPV.bi(this);
        window.logout = this.btg.bi(this);
        window.reg = this.bQb.bi(this);
        bj.bt(window, "login", this.Oc.bi(this));
        window.g_cbLogin = this.Bs.bi(this);
        window.g_cbBind = this.bQg.bi(this);
        window.g_cbDeleteBind = this.bQh.bi(this);
        this.Yf()
    };
    bc.Yf = function () {
        var eQ = {account: {}, profile: {}, bindings: []};
        if (typeof GUser !== "undefined") {
            eQ.profile.userId = GUser.userId;
            eQ.profile.nickname = GUser.nickname;
            eQ.profile.avatarUrl = GUser.avatarUrl
        }
        if (typeof GBinds !== "undefined") {
            eQ.bindings = GBinds
        }
        localCache.sq("user", eQ);
        this.Yg = bq.mA.bF();
        this.Yg.bt("onlogout", this.bQp.bi(this));
        this.Yg.bt("onmainaccountreplace", this.Bs.bi(this));
        if (!this.bQr(eQ)) this.btg()
    };
    bc.bPV = function (bu) {
        bo.oj.cw();
        bo.Bv.cw();
        bo.Ar.cw();
        if (typeof bu === "undefined")return bo.oj.bR({title: "登录"});
        if (bu === 0)return bo.Bv.bR({title: "手机号登录"});
        return bo.Ar.bR({title: "网易邮箱帐号登录"})
    };
    bc.bQb = function () {
        if (this.uh) this.uh.bW();
        this.uh = bo.OO.bF()
    };
    bc.Oc = function (be) {
        if (typeof GUser === "object" && be.user && be.user.profile) {
            var cni = be.user.profile;
            GUser.userId = cni.userId;
            GUser.nickname = cni.nickname;
            GUser.avatarUrl = cni.avatarUrl;
            GUser.djStatus = cni.djStatus
        }
        if (this.bnI("loginsuccess")) {
            this.bK("loginsuccess")
        } else {
            location.reload()
        }
    };
    bc.Bs = function (bp) {
        if (!bp || bp.code != 200)return;
        var kl = JSON.stringify(bp);
        localCache.sq("user", JSON.parse(kl));
        if (bp.loginType == 6) {
            if (this.bsU) this.bsU.bW();
            this.bsU = bo.btL.bF({user: bp, onsuccess: this.Oc.bi(this)})
        } else {
            if (bp.profile) {
                this.Oc({user: bp})
            } else {
                if (this.nf) this.nf.bW();
                this.nf = bo.zL.bF({user: bp, requiremobile: true, onsuccess: this.Oc.bi(this)})
            }
        }
    };
    bc.bQg = function (cr) {
        var be = cr.code == 200 ? "snsbind" : "snsbinderror", fU = bb.bG("g_iframe");
        if (cr.code == 200) {
            var eQ = localCache.bG("user") || {}, nh = NEJ.X(cr, {
                refreshTime: +(new Date) / 1e3 | 0,
                tokenJsonStr: JSON.stringify({expires_in: cr.expires_in})
            }), bv = -1;
            eQ.bindings = eQ.bindings || [];
            bm.cv(eQ.bindings, function (bQz, yn) {
                if (bQz.type == cr.type) bv = yn
            });
            if (bv >= 0) {
                eQ.bindings[bv] = nh
            } else {
                eQ.bindings.push(nh)
            }
            bA.cG("/api/point/sns", {
                type: "json", method: "get", query: {snsType: cr.type}, onload: function (bl) {
                    var cK = cr.point || bl.point;
                    if (cK > 0) {
                        bo.gz({title: "绑定成功", type: "success", mesg: '绑定成功 获得<em class="s-fc6">' + cK + "积分</em>"})
                    } else {
                        bo.ci.bR({tip: "绑定成功"})
                    }
                }.bi(this)
            })
        } else {
            var bv = bm.eg(ALL_ACCOUNT, function (bw) {
                return bw.type == cr.type
            });
            var hJ = bv >= 0 ? ALL_ACCOUNT[bv].title : "";
            if (cr.message) {
                bo.gz({title: "绑定" + hJ, type: "fail", mesg: "绑定失败", mesg2: cr.message})
            } else {
                bo.ci.bR({tip: "绑定失败，请重试", type: 2})
            }
        }
        try {
            var dB = fU.contentWindow;
            dB.nej.v.bK(dB, be, {result: cr})
        } catch (e) {
        }
        bj.bK(window, be, {result: cr})
    };
    bc.bQh = function (cr) {
        var be = cr.code == 200 ? "snsunbind" : "snsunbinderror", fU = bb.bG("g_iframe");
        if (cr.code == 200) {
            bo.ci.bR({tip: "已解除绑定"})
        } else if (cr.message) {
            bo.gz({title: "解除绑定", type: "fail", mesg: "解绑失败", mesg2: cr.message})
        } else {
            bo.ci.bR({tip: "解绑失败，请重试", type: 2})
        }
        try {
            var dB = fU.contentWindow;
            dB.nej.v.bK(dB, be, {result: cr})
        } catch (e) {
        }
        bj.bK(window, be, {result: cr})
    };
    bc.btg = function () {
        var be = {};
        this.bK("beforedologout", be);
        if (be.stopped) {
            return
        }
        bA.hI("MUSIC_U", {expires: -1});
        this.Yg.bKC();
        window.GUser = {};
        this.bK("logoutbefore")
    };
    bc.bQp = function (bp) {
        localCache.dW("user");
        localCache.dW("host-plist");
        if (typeof GUser === "object") {
            GUser.userId = 0;
            GUser.nickname = "";
            GUser.avatarUrl = ""
        }
        if (this.bnI("logoutsuccess")) {
            this.bK("logoutsuccess")
        } else {
            location.reload()
        }
    };
    bc.bQr = function (eQ) {
        var Ym = false;
        if (!eQ.bindings || eQ.bindings.length == 0)return true;
        bm.cv(eQ.bindings, function (bw) {
            if (bw.type == 0 || bw.type == 2 || bw.type == 5 || bw.type == 10) {
                Ym = true
            } else if (bw.type == 1) {
                var ki = JSON.parse(bw.tokenJsonStr || "{}");
                if (ki.hasPassword) {
                    Ym = true
                }
            }
        });
        return Ym
    };
    bI.gN.bF({element: window, event: ["login", "snsbind", "snsbinderror", "snsunbind", "snsunbinderror"]});
    bQ.Oi.iE()
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), cA = bd("nej.ui"), bI = bd("nej.ut"), bm = bd("nej.u"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), bc;
    bT.LB = NEJ.C();
    bc = bT.LB.bU(cA.gh);
    bc.dm = function () {
        this.dw();
        var bk = bb.eu(this.bs);
        this.bqg = bk[0];
        this.du = bk[1];
        this.cW = bk[2]
    };
    bc.dx = function () {
        this.dy = "g-select"
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.dq([[this.du, "click", this.Lu.bi(this)], [this.cW, "click", this.mc.bi(this)], [document, "click", this.og.bi(this)]]);
        this.baQ = bf.filter || this.bVJ;
        this.qY(bf.list)
    };
    bc.cR = function () {
        this.cV();
        delete this.dK;
        delete this.si;
        delete this.baQ
    };
    bc.qY = function (bk, oI) {
        if (!bk) {
            this.bqg.innerText = "－请选择－";
            return
        }
        this.dK = bk;
        bb.fR(this.cW, "g-select-item", {options: bk}, {filter: this.baQ});
        this.jI(oI || bk[0])
    };
    bc.qb = function () {
        return this.dK
    };
    bc.gn = function () {
        return this.si
    };
    bc.jI = function (bD) {
        if (this.si != bD) {
            this.si = bD;
            this.bqg.innerText = this.baQ(bD);
            this.bK("onchange", bD)
        }
    };
    bc.Lu = function (be) {
        bj.cu(be);
        if (bb.cU(this.cW, "f-hide")) {
            if (!this.dK || !this.dK.length)return;
            bb.bH(this.cW, "f-hide")
        } else {
            bb.bJ(this.cW, "f-hide")
        }
    };
    bc.og = function () {
        bb.bJ(this.cW, "f-hide")
    };
    bc.mc = function (be) {
        var bh = bj.bY(be, "d:index"), bv = bb.bz(bh, "index");
        if (bh) {
            this.jI(this.dK[bv])
        }
    };
    bc.bVJ = function (hl) {
        return hl.name
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), ej = bd("nej.p"), cA = bd("nej.ui"), bA = bd("nej.j"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bT = bd("nm.w"), gA = bd("nm.ut"), bc, bO;
    bT.zv = NEJ.C();
    bc = bT.zv.bU(cA.gh);
    bO = bT.zv.dr;
    bc.cz = function (bf) {
        this.cB(bf);
        this.fL = bf.type || 1;
        this.zu = bf.resource || {};
        this.Ou = bb.oZ(bb.dg("m-wgt-input-" + this.fL, {placeholder: bf.placeholder || ""}));
        this.bqK = bf.type == 2 ? true : false;
        var bk = bb.bP(this.Ou, "j-flag");
        this.gi = bk[0];
        this.bas = bb.bP(this.Ou, "btns")[0];
        this.pC = bk[3];
        this.bUV = bk[4];
        bb.gj(this.gi, "holder");
        if (bb.cU(this.gi.parentNode, "holder-parent")) {
            bb.ch(this.gi.parentNode, "display", "block")
        }
        this.gi.value = bf.input || "";
        this.bs.appendChild(this.Ou);
        this.oh = {start: 0, end: 0};
        if (!bf.nomention) {
            this.iI = bT.cmY.bF({parent: document.body, target: this.gi})
        } else {
            bb.ch(bk[2], "display", "none")
        }
        this.bau = bf.numLimit || 140;
        this.gv();
        this.bUZ();
        this.dq([[this.pC, "click", this.BU.bi(this)], [bk[2], "click", this.bax.bi(this)], [bk[1], "click", this.bay.bi(this)], [this.gi, "focus", this.kU.bi(this)], [this.gi, "input", this.iy.bi(this)], [this.gi, "keyup", this.sE.bi(this)], [this.gi, "click", this.lF.bi(this)]]);
        if (!bm.hC(bf.onbeforesubmit)) this.bt("onbeforesubmit", this.bVa.bi(this));
        if (!bm.hC(bf.onloading)) this.bt("onloading", this.bVc.bi(this))
    };
    bc.cR = function () {
        this.gi.value = "";
        if (this.hG) {
            this.hG.bW();
            delete this.hG
        }
        if (this.iI) {
            this.iI.bW();
            delete this.iI
        }
        this.cV();
        bb.dW(this.Ou)
    };
    bc.bVa = function () {
        var bD = this.gi.value;
        if (this.pC.className.indexOf("dis") >= 0)return;
        if (!this.BQ() || !this.zf())return;
        if (bn.jG(bD)) {
            bo.ci.bR({type: 2, tip: "输入点内容再提交吧"});
            return
        }
        if (bm.hk(bD) > 2 * this.bau) {
            bo.ci.bR({type: 2, tip: "输入不能超过" + this.bau + "个字符"});
            return
        }
        return !0
    };
    bc.bVc = function () {
        bb.bJ(this.pC, "u-btn-1-dis");
        if (this.pC.innerText.indexOf("...") < 0) {
            this.pC.innerText = this.pC.innerText + "..."
        }
        this.rm = !0
    };
    bc.wO = function () {
        if (!this.rm)return;
        this.rm = !1;
        bb.bH(this.pC, "u-btn-1-dis");
        var ew = this.pC.innerText;
        this.pC.innerText = ew.substring(0, ew.length - 3)
    };
    bc.lF = function () {
        this.oh = gA.sT(this.gi)
    };
    bc.BU = function (kf) {
        bj.cu(kf);
        var bD = this.gi.value;
        if (!this.bK("onbeforesubmit", {value: bD}))return;
        if (this.fL != 4) this.bK("onloading");
        gA.bAg(bD);
        if (this.iI) {
            this.iI.DP()
        }
        this.bK("onsubmit", bD);
        this.gv();
        return false
    };
    bc.yJ = function () {
        this.gi.value = "";
        this.gv()
    };
    bc.gn = function () {
        return this.gi.value || ""
    };
    bc.mK = function () {
        if (!this.zf())return;
        var cF = this.gn().length;
        this.gi.focus();
        gA.Sx(this.gi, {start: cF, end: cF});
        this.lF()
    };
    bc.bax = function (be) {
        bj.cu(be);
        if (!this.zf())return;
        !!this.hG && this.hG.cw();
        this.iI.GY();
        this.gv()
    };
    bc.bay = function (be) {
        bj.cu(be);
        if (!this.zf())return;
        if (!this.hG) {
            this.hG = bo.DQ.bF({parent: this.bas});
            this.hG.bt("onselect", this.vG.bi(this));
            bb.ch(this.hG.mL().parentNode, "position", "relative")
        }
        this.hG.bR()
    };
    bc.vG = function (be) {
        var cm = "[" + be.text + "]";
        bj.bK(this.gi, "focus");
        this.gi.focus();
        gA.cmS(this.gi, this.oh, cm);
        this.gv();
        bj.bK(this.gi, "keyup")
    };
    bc.iy = function (be) {
        ej.ek.browser == "ie" && ej.ek.version < "7.0" ? setTimeout(this.gv.bi(this), 0) : this.gv()
    };
    bc.sE = function (be) {
        this.lF();
        if (this.bqK) this.bVh();
        this.iy()
    };
    bc.BQ = function () {
        if (!GUser || !GUser.userId || GUser.userId < 0) {
            top.login();
            return
        }
        return true
    };
    bc.kU = function () {
        if (!this.BQ()) {
            this.gi.blur();
            return
        }
        if (!this.zf()) {
            this.gi.blur();
            return
        }
    };
    bc.gv = function () {
        var cF = this.bau - Math.ceil(bm.hk(this.gi.value) / 2);
        this.bUV.innerHTML = cF >= 0 ? cF : '<em class="s-fc6">' + cF + "</em>"
    };
    bc.bVh = function () {
        var bqw = 76;
        var bVn = function () {
            if (parseInt(en) > bqw) {
                bb.ch(this.gi, "height", "auto");
                bb.ch(this.gi, "height", bqw + "px");
                bb.ch(this.gi, "overflowY", "scroll")
            } else {
                bb.ch(this.gi, "height", "auto");
                bb.ch(this.gi, "height", en);
                bb.ch(this.gi, "overflowY", "hidden")
            }
        }.bi(this);
        var tG = function (string, number) {
            for (var i = 0, r = ""; i < number; i++)r += string;
            return r
        };
        this.Gl.innerHTML = this.gi.value.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/&/g, "&amp;").replace(/\n$/, "<br/>&nbsp;").replace(/\n/g, "<br/>").replace(/ {2,}/g, function (space) {
                return tG("&nbsp;", space.length - 1) + " "
            }) + "&nbsp";
        var en = this.Gl.offsetHeight > this.bqr ? this.Gl.offsetHeight : this.bqr;
        en += "px";
        var cdW = bb.ey(this.gi, "height");
        setTimeout(bVn, 10)
    };
    bc.cmW = function () {
        var po = ["overflowX", "overflowY", "fontSize", "fontFamily", "lineHeight"];
        for (var i = 0; i < po.length; i++) {
            bb.ch(this.Gl, po[i], bb.ey(this.gi, po[i]))
        }
        var eZ = this.gi.offsetWidth - parseInt(bb.ey(this.gi, "paddingLeft")) - parseInt(bb.ey(this.gi, "paddingRight")) + "px";
        bb.ch(this.Gl, "width", eZ)
    };
    bc.bUZ = function () {
        if (this.bqK) {
            if (!bb.bP(document.body, "shadow-textarea")[0]) {
                var eN = '<div style="position:absolute;border: none;left:-10000px;word-wrap: break-word;overflow: hidden;resize:none" class="shadow-textarea"></div>';
                var bh = bb.oZ(eN);
                document.body.appendChild(bh);
                this.Gl = bb.bP(document.body, "shadow-textarea")[0]
            } else {
                this.Gl = bb.bP(document.body, "shadow-textarea")[0]
            }
            this.bqr = parseInt(bb.ey(this.gi, "height"));
            bb.ch(this.gi, "overflow", "hidden");
            this.cmW()
        }
    };
    bc.zf = function () {
        var be = {};
        this.bK("oncheckvalid", be);
        return !be.stopped
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bm = bd("nej.u"), bj = bd("nej.v"), bI = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bq.fX({
        "message_chat-add": {
            url: "/api/msg/private/send", filter: function (bf) {
                this.baO(bf, 0)
            }, format: function (bp, bf) {
                this.baN(bp.newMsgs);
                if (bf.justSend) {
                    return bp
                } else {
                    return bp.newMsgs.reverse()
                }
            }, finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", {key: bf.key, action: "refresh"})
            }, onmessage: function (dX) {
                var dS = "";
                if (dX == 407) {
                    dS = "发送内容中不得包含非法字符"
                } else if (dX == 406 || dX == 405) {
                    dS = "输入过于频繁，请稍后再试"
                } else if (dX == 408) {
                    dS = "请不要重复发送"
                } else if (dX == 315) {
                    dS = "根据对方设置，你没有该操作权限"
                }
                if (!!dS) bo.ci.bR({tip: dS, type: 2})
            }
        },
        "message_chat-del": {
            url: "/api/msg/private/delete/single", format: function (bV, bf) {
                return bV.code == 200
            }, finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", {key: bf.key, action: "refresh"})
            }, onmessage: function (dX) {
            }
        },
        "message_chat-list": {
            url: "/api/msg/private/history", filter: function (bf) {
            }, format: function (bp, bf) {
                this.baN(bp.msgs);
                bp.msgs.length = bf.limit;
                return {total: bp.size, list: bp.msgs}
            }
        },
        "message_chat-pull": {
            url: "/api/msg/private/new", filter: function (bf) {
                this.baO(bf, 0)
            }, format: function (bp) {
                return bp.msgs
            }
        },
        "message_private-list": {
            url: "/api/msg/private/users", filter: function (bf) {
            }, format: function (bp, bf) {
                var dL = bp.size || 0, bk = bp.msgs;
                this.baK(bk);
                if (bf.offset + bf.limit < dL) {
                    bk.length = bf.limit
                }
                return {total: dL, list: bk}
            }
        },
        "message_private-pull": {
            url: "/api/msg/private/users", filter: function (bf) {
                bf.data.time = -1
            }, format: function (bp, bf) {
                this.wy(bf.key);
                this.baK(bp.msgs);
                return bp.msgs
            }
        },
        "message_private-del": {
            type: "GET", url: "/api/msg/private/delete", filter: function (bf) {
                var bB = bf.id;
                if (bB) bf.data = {userId: bB.split("-")[1]}
            }, format: function (bV, bf) {
                return bV
            }, finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", {key: bf.key, action: "refresh"})
            }, onmessage: function (dX) {
            }
        },
        "message_comment-list": {
            url: "/api/v1/user/comments/{uid}", format: function (bp, bf) {
                if (bf.data.offset == 0) this.bK("onnewcount", bp.newCount);
                this.bVz(bp);
                return {total: bp.total || 0, list: bp.comments}
            }
        },
        "message_comment-del": {
            url: "/api/user/comments/delete", finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", be)
            }
        },
        "message_user_comment-reply": {
            url: "/api/user/comments/reply", format: function (bV) {
                this.bK("onreply");
                bo.ci.bR({tip: "回复成功"});
                return bV
            }, onmessage: function () {
                bo.ci.bR({tip: "回复失败，请稍后再试", type: 2})
            }
        },
        "message_resource_comment-reply": {url: "/api/resource/comments/reply"},
        "message_notify-list": {
            url: "/api/msg/notices", filter: function (bf) {
            }, format: function (bp, bf) {
                if (bf.data.offset == 0) this.bK("onnewcount", bp.newCount);
                this.bVy(bp);
                return {total: bp.size || 0, list: bp.notices}
            }
        },
        "message_notify-del": {
            url: "TODO", format: function (bV, bf) {
                return bf.ext
            }, finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", {key: bf.key, action: "refresh"})
            }, onmessage: function (dX) {
                bn.bal({txt: "通知删除失败！"})
            }
        },
        "message_at-list": {
            url: "/api/forwards/get", filter: function (bf) {
            }, format: function (bp, bf) {
                bm.cv(bp.forwards, function (bw, bv) {
                    bw.isNew = bv < bp.newCount
                });
                bp.forwards.length = bf.limit;
                return {total: bp.size, list: bp.forwards}
            }
        },
        "message_at-pull": {
            url: "/api/forwards/get", filter: function (bf) {
                this.baO(bf, 0)
            }, format: function (bp, bf) {
                return bp.forwards
            }
        },
        "message_at-del": {
            url: "TODO", format: function (bV, bf) {
                return bf.ext
            }, finaly: function (be, bf) {
                bj.bK(bq.lQ, "listchange", {key: bf.key, action: "refresh"})
            }, onmessage: function (dX) {
                bn.bal({txt: "@消息删除失败！"})
            }
        },
        "event-like": {
            url: "/api/resource/like", onload: "oneventlike", filter: function (bf, cj) {
                if (bf.like) {
                    cj.url = "/api/resource/like";
                    cj.onload = "oneventlike"
                } else {
                    cj.url = "/api/resource/unlike";
                    cj.onload = "oneventunlike"
                }
            }, format: function (bp, bf) {
                bp.id = bf.id;
                bp.isInner = !!bf.isInner;
                return bp
            }
        }
    });
    bq.lQ = NEJ.C();
    bc = bq.lQ.bU(bq.ik);
    bO = bq.lQ.dr;
    bc.wF = function (bf, bw) {
        if (!bm.hh(bw)) {
            bO.wF.apply(this, arguments);
            return
        }
        bm.cv(bw, function (bl) {
            bO.wF.apply(this, [bf, bl])
        }, this)
    };
    bc.bVu = function (bw) {
        if (!bm.hh(bw)) {
            if (bw.type == 1) {
                bw.json = this.bqq(bw.json, bw.id)
            } else if (bw.type == 2) {
                bw.json = JSON.parse(bw.json);
                bw.json.resource = this.bqq(bw.json.resource)
            } else if (bw.type == 3) {
                bw.json = JSON.parse(bw.json)
            }
            return
        }
        bm.cv(bw, this.bVu, this)
    };
    bc.bqq = function (qB) {
        if (bm.gH(qB)) {
            qB = JSON.parse(qB)
        }
        if (!!qB.json && bm.gH(qB.json)) {
            qB.json = JSON.parse(qB.json);
            if (!!qB.json.event && !!qB.json.event.json && bm.gH(qB.json.event.json)) {
                qB.json.event.json = JSON.parse(qB.json.event.json)
            }
        }
        return qB
    };
    bc.baN = function (bw) {
        if (!bm.hh(bw)) {
            bw.msg = JSON.parse(bw.msg);
            return
        }
        bm.cv(bw, this.baN, this)
    };
    bc.baK = function (bw) {
        if (!bm.hh(bw)) {
            bw.id = bw.toUser.userId + "-" + bw.fromUser.userId;
            bw.lastMsg = JSON.parse(bw.lastMsg);
            return
        }
        bm.cv(bw, this.baK, this)
    };
    bc.bVz = function (bl) {
        var cE = {
            0: "/playlist?id={id}",
            1: "/dj?id={id}",
            2: "/event?id={id}&uid={userId}",
            3: "/album?id={id}",
            4: "/song?id={id}",
            5: "/mv?id={id}",
            6: "/topic?id={id}"
        };
        bm.cv(bl.comments, function (bw, bv) {
            bw.resourceJson = JSON.parse(bw.resourceJson);
            bw.resUrl = bn.Fn(cE[bw.resourceType], bw.resourceJson)
        }, this)
    };
    bc.bVy = function () {
        var bVt = function (cJ) {
            var bV, dT = "";
            try {
                bV = JSON.parse(cJ.json)
            } catch (e) {
                bV = {}
            }
            switch (cJ.type) {
                case 12:
                    dT = "我创建了歌单";
                    dT = dT + "「" + bV.playlist.name + "」by " + bV.playlist.creator.nickname;
                    break;
                case 13:
                    dT = "我分享了歌单";
                    dT = dT + "「" + bm.fd(bV.playlist.name) + "」by " + bV.playlist.creator.nickname;
                    break;
                case 14:
                    dT = "我收藏了歌单";
                    dT = dT + "「" + bm.fd(bV.playlist.name) + "」by " + bV.playlist.creator.nickname;
                    break;
                case 15:
                case 16:
                    dT = "我创建了节目";
                    dT = dT + "「" + bV.program.name + "」by " + bV.program.dj.nickname;
                    break;
                case 17:
                    dT = "我分享了节目";
                    dT = dT + "「" + bV.program.name + "」by " + bV.program.dj.nickname;
                    break;
                case 18:
                    dT = "我分享了歌曲";
                    dT = dT + "「" + bV.song.name + "」by ";
                    for (var i = 0, l = bV.song.artists.length; i < l; i++) {
                        dT = dT + bV.song.artists[i].name;
                        if (i < l - 1) dT = dT + "/"
                    }
                    break;
                case 19:
                    dT = "我分享了专辑";
                    dT = dT + "「" + bV.album.name + "」by " + bV.album.artist.name;
                    break;
                case 36:
                    dT = "我分享了歌手";
                    dT = dT + "「" + bV.resource.name + "」";
                    break;
                case 21:
                    dT = "我分享了MV";
                    dT = dT + "「" + bV.mv.name + "」by " + bV.mv.artistName;
                    break;
                case 22:
                    dT = "我的动态:" + (bn.rP(bm.fd(bV.msg), "s-fc3") || "转发");
                    break;
                case 23:
                    dT = "我收藏了节目";
                    dT = dT + "「" + bV.program.name + "」by " + bV.program.dj.nickname;
                    break;
                case 24:
                    dT = "我分享了专栏文章";
                    dT = dT + "「" + bV.topic.mainTitle + "」";
                    break;
                case 28:
                    dT = "我分享了电台";
                    dT = dT + "「" + bV.djRadio.name + "」by " + bV.djRadio.dj.nickname;
                    break;
                case 31:
                    dT = "我分享了评论：";
                    dT = dT + bn.rP((bV.resource || cg).content || "");
                    break;
                case 35:
                    dT = "我的动态:" + bn.rP(bm.fd(bV.msg), "s-fc3") + (cJ.pics && cJ.pics.length ? "[图片]" : "");
                    break;
                case 39:
                    dT = "我发布了短视频";
                    break
            }
            bV.str = dT;
            return bV
        };
        var bVp = function (baH) {
            var cE = {
                A_PL_0: "playlist",
                R_MV_5: "mv",
                A_TO_6: "topic",
                A_DJ_1: "dj",
                A_EV_2: "event",
                R_AL_3: "album",
                R_SO_4: "song",
                A_DR_14: "radio"
            };
            if (/^(\w_\w{2}_\d+)+_(.+)$/.test(baH)) {
                var bu = cE[RegExp.$1], jF = RegExp.$2.split("_");
                return "/" + bu + "?id=" + jF[0] + (bu == "event" ? "&uid=" + jF[1] : "") + "&_hash=comment-box"
            }
        };
        var bVl = function (fN) {
            var fN = JSON.parse(fN);
            switch (fN.type) {
                case 1:
                    if (!fN.track)return;
                    fN.msg = "赞了你的动态";
                    fN.url = "/event?id=" + fN.track.id + "&uid=" + GUser.userId;
                    fN.track = bVt(fN.track);
                    break;
                case 2:
                    fN.msg = "收藏了你的歌单";
                    fN.url = "/playlist?id=" + fN.playlist.id;
                    fN.res = fN.playlist;
                    break;
                case 3:
                    fN.msg = "分享了你的歌单";
                    fN.url = "/playlist?id=" + fN.playlist.id;
                    fN.res = fN.playlist;
                    break;
                case 4:
                    fN.msg = "分享了你的节目";
                    fN.url = "/dj?id=" + fN.program.id;
                    fN.res = fN.program;
                    break;
                case 5:
                    fN.msg = "收藏了你的节目";
                    fN.url = "/dj?id=" + fN.program.id;
                    fN.res = fN.program;
                    break;
                case 6:
                    fN.msg = "赞了你的评论";
                    fN.url = bVp(fN.comment.threadId);
                    fN.comment = fN.comment;
                    break;
                case 7:
                    fN.msg = "赞了你的节目";
                    fN.url = "/dj?id=" + fN.program.id;
                    fN.res = fN.program;
                    break;
                case 8:
                    fN.msg = "订阅了你的电台";
                    fN.url = "/radio?id=" + fN.djRadio.id;
                    fN.res = fN.djRadio;
                    break;
                case 9:
                    fN.msg = "赞了你的专栏文章";
                    fN.url = "/topic?id=" + fN.topic.id;
                    fN.topic = fN.topic;
                    break;
                case 10:
                    if (!fN.generalNotice)return;
                    fN.msg = fN.generalNotice.actionDesc;
                    fN.url = fN.generalNotice.webUrl;
                    fN.generalContent = fN.generalNotice.content;
                    break
            }
            return fN
        };
        return function (bl) {
            bm.cv(bl.notices, function (bw, bv) {
                bw.notice = bVl(bw.notice)
            }, this)
        }
    }();
    bc.baO = function (bf, bv, bN) {
        var cT = -1, bk = this.hT(bf.key), cq = bf.offset, cq = cq != null ? cq : bk.length;
        if (bk.length > 0) {
            cT = bk[bv != null ? bv : cq - 1][bN || "time"]
        }
        bf.data.time = cT
    };
    bc.bVk = function (bf) {
        bf.onload = this.bVj.bi(this);
        this.dJ("message_resource_comment-reply", bf)
    };
    bc.bVj = function (be) {
        this.bK("onreply2", be)
    };
    bc.baj = function (bf) {
        this.dJ("message_user_comment-reply", bf)
    };
    bc.CJ = function (be) {
        this.bK("onreply", be)
    };
    bc.bcO = function (bf) {
        bf.onload = this.HO.bi(this);
        this.dJ("message_chat-add", bf)
    };
    bc.HO = function (be) {
        this.bK("onsend", be)
    };
    bc.xq = function (bf) {
        this.dJ("event-like", bf)
    };
    bI.gN.bF({element: bq.lQ, event: "listchange"})
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bA = bd("nej.j"), cg = bd("nej.o"), bm = bd("nej.u"), bj = bd("nej.v"), ej = bd("nej.p"), bT = bd("nm.w"), bn = bd("nm.x"), di = bd("nej.ui"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.cna = NEJ.C();
    bc = bo.cna.bU(bo.fz, !0);
    bO = bo.cna.prototype;
    bc.dx = function () {
        this.dy = "m-msg-private-send"
    };
    bc.dm = function () {
        this.dw();
        var cI = bb.bP(this.bs, "j-flag");
        this.tO = {parent: cI[1], err: cI[0]};
        this.fT = {parent: cI[2], type: 4, nomention: true, numLimit: 200, onsubmit: this.HX.bi(this)};
        if (ej.ek.browser == "ie" && ej.ek.version < "8.0") {
            bb.ch(cI[0], "position", "relative");
            bb.ch(cI[0], "zIndex", "10")
        }
    };
    bc.cz = function (bf) {
        bf.parent = document.body;
        bf.clazz = "";
        bf.onclose = function () {
            this.cR()
        }.bi(this);
        bf.mask = true;
        this.cB(bf);
        !!bf.receiver && (this.tO.receiver = bf.receiver);
        this.ob = bT.zY.bF(this.tO);
        this.eP = bT.zv.bF(this.fT);
        this.bS = bq.lQ.bF({
            onsend: this.HO.bi(this), onerror: function () {
                this.eP.wO()
            }.bi(this)
        })
    };
    bc.cR = function () {
        this.cV();
        if (!!this.ob) {
            this.ob.bW();
            delete this.ob
        }
        if (!!this.eP) {
            this.eP.bW();
            delete this.eP
        }
    };
    bc.HX = function (bD) {
        if (!!bD) {
            var KD = this.ob.Kg();
            if (!!KD.length) {
                this.bS.bcO({data: {type: "text", msg: bD, userIds: JSON.stringify(KD)}, justSend: true});
                this.eP.bK("onloading")
            } else {
                bn.gz({title: "提示", message: "请选择私信发送对象"})
            }
        } else {
            bn.gz({title: "提示", message: "私信内容不能为空"})
        }
    };
    bc.HO = function (bp) {
        this.cw();
        if (bp.code == 200) {
            bo.ci.bR({tip: "发送成功"})
        } else {
            bo.ci.bR({tip: "发送失败", type: 2})
        }
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bj = bd("nej.v"), bb = bd("nej.e"), bA = bd("nej.j"), bm = bd("nej.u"), bo = bd("nm.l"), bT = bd("nm.w"), di = bd("nej.ui"), bq = bd("nm.d"), bn = bd("nm.x"), bc, bO;
    bo.baz = NEJ.C();
    bc = bo.baz.bU(bo.fz);
    bO = bo.baz.dr;
    bc.dx = function () {
        this.dy = "m-question"
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.fu = bk[1];
        this.qd = bk[2];
        this.ob = bT.LB.bF({filter: this.bUX, parent: bk[0]});
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.cz = function (bf) {
        bf.parent = bf.parent || document.body;
        bf.title = "回答安全问题";
        bf.draggable = !0;
        bf.destroyalbe = !0;
        bf.mask = true;
        this.cB(bf);
        this.ob.qY(bf.data || [])
    };
    bc.cR = function () {
        this.cV();
        this.fu.value = ""
    };
    bc.BR = function () {
        this.cw()
    };
    bc.cS = function (be) {
        var bh = bj.bY(be, "d:action");
        switch (bb.bz(bh, "action")) {
            case"back":
                this.bK("onback");
                this.cw();
                break;
            case"next":
                var bqE = this.fu.value.trim();
                if (!bqE) {
                    this.jP("请输入回答");
                    return
                }
                var bl = {questionId: this.ob.gn().id, answer: bm.lB(bqE)};
                this.jP(null);
                bA.cG("/store/api/security/validateAnswer", {
                    type: "json",
                    method: "post",
                    data: bm.eX(bl),
                    onload: this.bqG.bi(this),
                    onerror: this.bqG.bi(this)
                });
                break
        }
    };
    bc.bUX = function (bw) {
        return bw.question
    };
    bc.jP = function (dS) {
        if (dS) {
            this.qd.innerHTML = '<i class="u-icn u-icn-25"></i>' + dS;
            bb.bH(this.qd, "f-hide")
        } else {
            bb.bJ(this.qd, "f-hide")
        }
    };
    var bqH = function (be) {
        try {
            top.doMsgToServiceAction(be)
        } catch (e) {
        }
    };
    bc.bqG = function (be) {
        if (be && be.code == 200) {
            this.bK("onnext");
            this.cw()
        } else {
            var cE = {"-3": "回答错误，您还有" + be.times + "次机会！"};
            if (be.code == -2 || be.code == -4) {
                bn.gz({
                    clazz: "m-layer-w2",
                    title: "更换手机号",
                    message: "<p>帐号已被锁定</p>" + '<p class="f-mgt10">回答错误的次数过多，您的帐号已被锁定，将无法进行任何商城交易，<br/>' + '请私信<a class="s-fc7" href="javascript:;" data-action="kf">@云音乐客服</a> 解锁。</p>',
                    btntxt: "知道了",
                    action: bqH
                });
                this.cw()
            } else {
                this.jP(cE[be.code] || "回答出错")
            }
        }
    };
    bn.bqI = function (bf) {
        var bqJ = function (be) {
            if (be && be.code == 200) {
                bf.data = be.data;
                bo.baz.bF(bf).bR()
            } else {
                bn.gz({
                    clazz: "m-layer-w2",
                    message: '私信 <a class="s-fc7" href="javascript:;" data-action="kf">@云音乐客服</a>',
                    action: bqH
                })
            }
        };
        bA.cG("/store/api/security/getQuestion", {type: "json", method: "get", onload: bqJ, onerror: bqJ})
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), fc = bd("nej.ut"), bn = bd("nm.x"), bq = bd("nm.d"), bo = bd("nm.l"), bc, bO;
    bo.Ov = NEJ.C();
    bc = bo.Ov.bU(fc.dZ);
    bc.cz = function (bf) {
        this.cB(bf);
        this.ed = bf;
        this.bqL = bf.mobile;
        this.bS = bq.mA.bF();
        this.bS.bt("onsendcaptcha", this.wK.bi(this));
        this.bS.bt("onsendcaptchaerror", this.KK.bi(this));
        this.bS.bt("onchangemobile", this.bUU.bi(this));
        this.bS.bt("onchangemobileerror", this.bUQ.bi(this));
        this.bam()
    };
    bc.cR = function () {
        this.cV();
        this.bS.bW();
        if (this.fD) this.fD.bW();
        if (this.Gw) this.Gw.bW()
    };
    bc.bam = function () {
        if (this.fD) this.fD.cw();
        if (this.Gw) this.Gw.bW();
        this.Gw = bn.lg({
            title: "更换手机号", clazz: "m-layer-find", txt: "txt-mobilestatus", onaction: function (be) {
                if (be.action == "valid") {
                    this.bS.Bn({data: {cellphone: this.bqL}})
                } else {
                    bn.bqI({title: "更换手机号", onback: this.bam.bi(this), onnext: this.bqQ.bi(this)})
                }
            }.bi(this)
        })
    };
    bc.wK = function (cr) {
        this.fD = bo.qq.bR({
            title: "更换手机号",
            mobile: this.bqL,
            okbutton: "下一步",
            onok: this.bqQ.bi(this),
            backbutton: "&lt;&nbsp;&nbsp;上一步",
            onback: this.bam.bi(this)
        })
    };
    bc.KK = function () {
        bo.ci.bR({tip: "更换失败，请重试", type: 2})
    };
    bc.bqQ = function (eK) {
        this.fD = bo.qq.bR({title: "更换手机号", mobileLabel: "新手机号：", okbutton: "完成", onok: this.bUG.bi(this, eK.captcha)})
    };
    bc.bUG = function (cub, cr) {
        this.bqS = cr.mobile;
        this.dn = cr.captcha;
        this.bS.bLl({data: {phone: this.bqS, captcha: this.dn, oldcaptcha: cub}})
    };
    bc.bUU = function (cr) {
        this.fD.cw();
        bo.ci.bR({tip: "更换成功"});
        if (this.ed.onsuccess) this.ed.onsuccess({mobile: this.bqS})
    };
    bc.bUQ = function (cr) {
        if (cr.code == 506) {
            this.fD.dF(false);
            this.fD.dh(cr.message, "mobile")
        } else {
            this.fD.cw();
            bo.ci.bR({tip: "更换失败，请重试", type: 2})
        }
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bA = bd("nej.j"), bI = bd("nej.ut"), bm = bd("nej.u"), bn = bd("nm.x"), bo = bd("nm.l"), hY = bd("api"), bT = bd("nm.w");
    var bae = null, bqU = null;
    var bUA = function (fS, bqW) {
        if (bae) bae.bW();
        bae = bo.Ov.bF({
            title: "更换手机号", mobile: fS, onsuccess: function (cr) {
                if (bqW) bqW({cellphone: cr.mobile})
            }
        })
    };
    var bUw = function (bf) {
        bA.cG("/api/sms/captcha/sent", {
            type: "json",
            query: {cellphone: bf.mobile, channel: "new"},
            onload: function (be) {
                if (be.code != 200)return bo.ci.bR({tip: "验证码发送失败", type: 2});
                bqU = bo.qq.bR({
                    title: bf.title || "验证手机号",
                    mobile: bf.mobile,
                    okbutton: bf.ntext || "下一步",
                    onok: function (cr) {
                        bqU.cw();
                        if (bf.onnext) bf.onnext(cr)
                    }
                })
            },
            onerror: function () {
                bo.ci.bR({tip: "验证码发送失败", type: 2})
            }
        })
    };
    hY.changePhone = bUA;
    hY.phoneCode = bUw;
    hY.validateQuestion = bn.bqI
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), cf = bd("nej.h"), bM = bd("nej.p");
    var qJ = {opacity: 1, "z-index": 1, background: 1, "font-weight": 1, filter: 1};
    cf.bnf = function (kh) {
        return qJ[kh] === undefined && kh.indexOf("color") < 0
    };
    cf.cuK = function (bh, uC, pQ) {
        pQ = pQ.slice(0, -1);
        bb.ch(bh, "transition", pQ);
        bb.fp(bh, uC);
        return this
    };
    cf.Hm = function (bh, eD, pE) {
        bb.fp(bh, eD);
        bb.ch(bh, "transition", "none");
        pE.call(null, eD);
        return this
    }
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, cf = bd("nej.h"), bM = bd("nej.p");
    if (bM.ns.trident1)return;
    cf.Ay = function () {
        return !0
    }
})();
(function () {
    var bd = NEJ.P, bM = bd("nej.ut"), bc;
    if (!!bM.bfM)return;
    bM.bfM = NEJ.C();
    bc = bM.bfM.bU(bM.zQ);
    bc.cz = function (bf) {
        bf = NEJ.X({}, bf);
        bf.timing = "easeout";
        this.cB(bf)
    }
})();
(function () {
    var bd = NEJ.P, bM = bd("nej.ut"), bc;
    if (!!bM.bfN)return;
    bM.bfN = NEJ.C();
    bc = bM.bfN.bU(bM.zQ);
    bc.cz = function (bf) {
        bf = NEJ.X({}, bf);
        bf.timing = "easeinout";
        this.cB(bf)
    }
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), cf = bd("nej.h"), bM = bd("nej.p"), dY = bd("nej.x"), fc = bd("nej.ut");
    if (bM.ns.trident)return;
    var bmv = {linear: fc.Cc, "ease-in": fc.Ej, "ease-out": fc.bfM, "ease-in-out": fc.bfN};
    cf.cuK = function () {
        var ccC = function (uC, pQ) {
            var dT = "";
            bm.fo(uC, function (bD, bX) {
                dT += pQ.replace("all", bX)
            });
            return dT
        };
        var ccF = function (bD, kh) {
            if (kh === "filter") {
                bD = bm.Lh(bD, 0);
                bD = "alpha(opacity=" + bD + ")"
            }
            if (kh === "z-index") bD = bm.Lh(bD, 0);
            return bD
        };
        var ccH = function (bD) {
            return bmv[bD.split(" ")[2]]
        };
        var ccI = function (bh, bD, uC, pE, bv) {
            var bD = bD.split(" "), kh = bD[0], eO = parseFloat(bb.ey(bh, kh)) || 0, nA = parseFloat(uC[kh]) || 0, ccJ = bmv[bD[2]], bfU = bD[1].slice(0, -1) * 1e3 + bD[3].slice(0, 1) * 1e3;
            if (bfU >= bh.sumTime) {
                bh.sumTime = bfU;
                bh.isLastOne = bv
            }
            var Mq = nej.p.ek.engine === "trident" && nej.p.ek.release - 5 < 0;
            if (kh === "opacity" && Mq) {
                kh = "filter";
                var eV = bb.ey(bh, kh);
                eO = parseFloat(eV.split("=")[1]) || 0;
                nA = nA * 100
            }
            var bf = {
                from: {offset: eO}, to: {offset: nA}, duration: bfU, onupdate: function (cq) {
                    var bD = cq.offset;
                    if (!cf.bnf(kh)) {
                        bD = ccF(bD, kh);
                        bb.ch(bh, kh, bD)
                    } else {
                        bb.ch(bh, kh, bD + "px")
                    }
                }, onstop: function (kh) {
                    var Ec = bh.effects[bv];
                    if (!Ec)return;
                    Ec = ccJ.bW(Ec);
                    if (bh.isLastOne === bv) pE.apply(this)
                }.bi(this, bv)
            };
            return bf
        };
        return cf.cuK.fj(function (be) {
            be.stopped = !0;
            var bk = be.args;
            var bh = bk[0], uC = bk[1], pQ = bk[2], pE = bk[3];
            bh.sumTime = 0, bh.isLastOne = 0;
            var bmp = [];
            if (pQ.indexOf("all") > -1) pQ = ccC(uC, pQ);
            var bfY = pQ.slice(0, -1);
            bfY = bfY.split(",");
            bh.effects = [];
            bm.cv(bfY, function (bD, bv) {
                var bf = ccI(bh, bD, uC, pE, bv);
                bmp.push({o: bf, c: ccH(bD)})
            });
            bm.cv(bmp, function (bw, bv) {
                var Ec = bw.c.bF(bw.o);
                bh.effects[bv] = Ec;
                Ec.hj()
            });
            return this
        })
    }();
    cf.Hm = cf.Hm.fj(function (be) {
        be.stopped = !0;
        var bk = be.args;
        var bh = bk[0];
        bm.cv(bh.effects, function (cg) {
            cg.cu()
        });
        bh.effects = [];
        return this
    })
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, cf = bd("nej.h"), bb = bd("nej.e"), bM = bd("nej.p");
    if (bM.ns.gecko)return;
    cf.cuK = function (bh, uC, pQ) {
        pQ = pQ.slice(0, -1);
        bb.ch(bh, "transition", pQ);
        setTimeout(function () {
            bb.fp(bh, uC)
        }, 33);
        return this
    }
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, cf = bd("nej.h"), bM = bd("nej.p");
    if (bM.ns.webkit)return
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, cf = bd("nej.h"), bM = bd("nej.p");
    if (bM.ns.presto)return
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bm = bd("nej.u"), cf = bd("nej.h"), bb = bd("nej.e"), bj = bd("nej.v"), bM = bd("nej.ut"), sh;
    if (!!bM.ql)return;
    bM.ql = NEJ.C();
    sh = bM.ql.bU(bM.dZ);
    sh.cz = function (bf) {
        this.cB(bf);
        this.DY = bb.bG(bf.node);
        this.bmn = bf.styles || [];
        this.bmm = bf.onstop || cC;
        this.bge = bf.transition || [];
        this.LH = {};
        this.bml = this.ccO();
        if (!!cf.Ay && cf.Ay()) {
            setTimeout(this.Ay.bi(this), this.bgi * 1e3)
        } else {
            this.dq([[this.DY, "transitionend", this.Ay.bi(this)]])
        }
    };
    sh.cR = function () {
        if (!!this.DV) {
            this.DV = window.clearInterval(this.DV)
        }
        delete this.DY;
        delete this.bmn;
        delete this.bml;
        delete this.LH;
        delete this.bgk;
        delete this.bge;
        delete this.DV;
        this.cV()
    };
    sh.Ay = function (be) {
        if (!!cf.Ay && cf.Ay()) {
            this.bgl = !1;
            this.cu();
            return
        }
        if (!!this.bgl && this.ccT(be)) {
            this.bgl = !1;
            this.cu()
        }
    };
    sh.ccT = function (be) {
        var bX = be.propertyName;
        if (bX === this.bgk || bX.indexOf(this.bgk) > -1)return !0; else return !1
    };
    sh.ccO = function () {
        var cdc = function (ds) {
            var bk = ds.split(":"), kh = bk[0], bD = bk[1], bh = this.DY;
            if (bD.indexOf("=") > -1) {
                var DT = parseInt(bb.ey(bh, kh)) || 0;
                var ej = parseInt(bD.split("=")[1]);
                if (bD.indexOf("+") > -1) bD = DT + ej; else bD = DT - ej
            }
            if (cf.bnf(kh)) {
                if (bD.toString().indexOf("px") < 0) bD += "px"
            }
            this.LH[kh] = bD
        };
        var cbQ = function (bv) {
            if (!this.bge[bv])return "";
            var qZ = this.bge[bv], bI = qZ.duration + qZ.delay;
            if (bI >= this.bgi) {
                this.bgi = bI;
                this.bgk = qZ.property
            }
            return qZ.property + " " + qZ.duration + "s " + qZ.timing + " " + qZ.delay + "s,"
        };
        return function () {
            var bmc = "";
            this.bgi = 0;
            bm.cv(this.bmn, function (ds, bv) {
                cdc.call(this, ds);
                bmc += cbQ.call(this, bv)
            }.bi(this));
            return bmc
        }
    }();
    sh.caJ = function () {
        this.wo = {};
        bm.fo(this.LH, function (bD, kh) {
            this.wo[kh] = bb.ey(this.DY, kh)
        }.bi(this));
        this.bK("onplaystate", this.wo)
    };
    sh.xP = function () {
        this.bgl = !0;
        cf.cuK(this.DY, this.LH, this.bml, this.bmm);
        this.DV = window.setInterval(this.caJ.bi(this), 49);
        return this
    };
    sh.cu = function () {
        cf.Hm(this.DY, this.LH, this.bmm);
        this.DV = window.clearInterval(this.DV);
        return this
    };
    sh.cdu = function () {
    };
    sh.cdD = function () {
    }
})();
(function () {
    var bd = NEJ.P, cC = NEJ.F, bm = bd("nej.u"), bb = bd("nej.e"), bm = bd("nej.u"), bM = bd("nej.ut");
    bb.SL = function (bf) {
        bf = bf || {};
        bf.onstop = bf.onstop || cC;
        bf.onplaystate = bf.onplaystate || cC;
        return bf
    };
    bb.blQ = function () {
        var bYk = function (bh, SO, Mq) {
            var gk, fI = true;
            if (!!Mq) {
                bm.fo(SO, function (bD, bX) {
                    if (bX === "opacity") {
                        bX = "filter";
                        var eV = bb.ey(bh, bX);
                        if (eV === "") {
                            bb.ch(bh, "filter", "alpha(opacity=100)");
                            gk = 100
                        } else {
                            gk = parseFloat(eV.split("=")[1]) || 0
                        }
                        bD = bD * 100
                    } else {
                        gk = bb.ey(bh, bX)
                    }
                    if (parseInt(gk) === bD) fI = false
                }.bi(this))
            } else {
                bm.fo(SO, function (bD, bX) {
                    gk = bb.ey(bh, bX);
                    if (parseInt(gk) === bD) fI = false
                }.bi(this))
            }
            return fI
        };
        return function (bh, SO) {
            var Mq = nej.p.ek.engine === "trident" && nej.p.ek.release - 5 < 0;
            if (!bYk(bh, SO, Mq))return !1;
            return !0
        }
    }();
    bb.blN = function () {
        var bYi = function (bh) {
            var Ui = bb.ey(bh, "display");
            if (Ui === "none")return !1;
            return !0
        };
        return function (bh, bf, oI) {
            var GL = bf.opacity || oI;
            bh = bb.bG(bh);
            if (!bYi.call(bh))return !1;
            if (!!bh.effect)return !1;
            if (!bb.blQ(bh, {opacity: GL}))return !1;
            bf = bb.SL(bf);
            bh.effect = bM.ql.bF({
                node: bh,
                transition: [{
                    property: "opacity",
                    timing: bf.timing || "ease-in",
                    delay: bf.delay || 0,
                    duration: bf.duration || 1
                }],
                styles: ["opacity:" + GL],
                onstop: function (eD) {
                    bh.effect = bM.ql.bW(bh.effect);
                    bf.onstop.call(null, eD)
                },
                onplaystate: bf.onplaystate.bi(bh.effect)
            });
            bh.effect.xP();
            return this
        }
    }.bi(this)();
    bb.blK = function (bh, bf) {
        return bb.blN(bh, bf, 1)
    };
    bb.bYa = function (bh, bf) {
        return bb.blN(bh, bf, 0)
    };
    bb.bXk = function (bh) {
        bb.bWT(bh);
        return this
    };
    bb.bWT = function (bh) {
        bh = bb.bG(bh);
        if (bh.effect && bh.effect.cu()) {
            if (!!bh.effect) bh.effect = bM.ql.bW(bh.effect)
        }
        return this
    };
    bb.cdT = function (bh, ld, bf) {
        bh = bb.bG(bh);
        if (!!bh.effect)return !1;
        if (!bb.blQ(bh, ld))return !1;
        bf = bb.SL(bf);
        bf.duration = bf.duration || [];
        var hs = ld.top || 0, jQ = ld.left || 0;
        bh.effect = bM.ql.bF({
            node: bh,
            transition: [{
                property: "top",
                timing: bf.timing || "ease-in",
                delay: bf.delay || 0,
                duration: bf.duration[0] || 1
            }, {property: "left", timing: bf.timing || "ease-in", delay: bf.delay || 0, duration: bf.duration[1] || 1}],
            styles: ["top:" + hs, "left:" + jQ],
            onstop: function (eD) {
                bf.onstop.call(null, eD);
                bh.effect = bM.ql.bW(bh.effect)
            },
            onplaystate: bf.onplaystate.bi(bh.effect)
        });
        bh.effect.xP();
        return this
    };
    bb.blE = function () {
        return function (bh, ld, bf) {
            bh = bb.bG(bh);
            if (!!bh.effect)return !1;
            bf = bb.SL(bf);
            var bk = ld.split(":"), bVQ = bk[0], blC = [];
            blC.push(ld);
            bh.effect = bM.ql.bF({
                node: bh,
                transition: [{
                    property: bVQ,
                    timing: bf.timing || "ease-in",
                    delay: bf.delay || 0,
                    duration: bf.duration || 1
                }],
                styles: blC,
                onstop: function (eD) {
                    bf.onstop.call(null, eD);
                    bh.effect = bM.ql.bW(bh.effect)
                },
                onplaystate: bf.onplaystate.bi(bh.effect)
            });
            bh.effect.xP();
            return this
        }
    }();
    bb.cea = function () {
        var bgK = function (bh, bu) {
            return bu == "height" ? bh.clientHeight : bh.clientWidth
        };
        return function (bh, bu, bf) {
            bh = bb.bG(bh);
            if (!!bh.effect)return !1;
            bf = bb.SL(bf);
            var bD = bf.value || false;
            if (!bD) {
                bb.ch(bh, "display", "block");
                var bh = bb.bG(bh);
                bD = bgK(bh, bu)
            }
            var fI = bb.ey(bh, "visibility");
            if (fI === "hidden") {
                bh.style.height = 0;
                bb.ch(bh, "visibility", "inherit");
                bh.effect = bM.ql.bF({
                    node: bh,
                    transition: [{
                        property: bu,
                        timing: bf.timing || "ease-in",
                        delay: bf.delay || 0,
                        duration: bf.duration || 1
                    }],
                    styles: [bu + ":" + bD],
                    onstop: function (eD) {
                        bf.onstop.call(null, eD);
                        bh.effect = bM.ql.bW(bh.effect);
                        SW = window.clearTimeout(SW)
                    },
                    onplaystate: bf.onplaystate.bi(bh.effect)
                })
            } else {
                bh.style.height = bD;
                bh.effect = bM.ql.bF({
                    node: bh,
                    transition: [{
                        property: bu,
                        timing: bf.timing || "ease-in",
                        delay: bf.delay || 0,
                        duration: bf.duration || 1
                    }],
                    styles: [bu + ":" + 0],
                    onstop: function (eD) {
                        bb.ch(bh, "visibility", "hidden");
                        bb.ch(bh, bu, "auto");
                        bf.onstop.call(null, eD);
                        bh.effect = bM.ql.bW(bh.effect);
                        SW = window.clearTimeout(SW)
                    },
                    onplaystate: bf.onplaystate.bi(bh.effect)
                })
            }
            var SW = window.setTimeout(function () {
                bh.effect.xP()
            }.bi(this), 0);
            return this
        }
    }()
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bI = bd("nej.ut"), bm = bd("nej.u"), di = bd("nej.ui"), bn = bd("nm.x"), bq = bd("nm.d"), bT = bd("nm.w"), hY = bd("api"), bc, bO;
    bT.AH = NEJ.C();
    bc = bT.AH.bU(di.gh);
    bO = bT.AH.dr;
    bc.dx = function () {
        this.dy = "m-image-preview"
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.IM = bk[0];
        this.Gz = bk[1];
        this.gZ = bk[2];
        this.MI = bk[3];
        this.MP = bk[4];
        this.ZX = bk[5]
    };
    bc.cz = function (bf) {
        this.cB(bf);
        this.bUs();
        this.rT = bf.urls;
        this.ig = this.rT.length;
        if (this.ig == 1) {
            bb.ch(this.MI, "display", "none");
            bb.ch(this.MP, "display", "none")
        }
        this.dq([[this.bs, "click", this.cS.bi(this)], [document, "keydown", this.bUa.bi(this)]]);
        bn.buK(this.rT, function (xb, gf) {
            this.rF = gf;
            this.oW(bf.index || 0)
        }.bi(this))
    };
    bc.cR = function () {
        this.cV();
        bb.bJ(this.Gz, "fail-loading");
        bb.bH(this.Gz, "f-hide");
        bb.ch(this.MI, "display", "");
        bb.ch(this.MP, "display", "");
        bb.bH(this.MI, "z-cntdis");
        bb.bH(this.ip, "z-cntdis");
        bb.bH(this.MP, "z-cntdis");
        bb.bH(this.MU, "z-cntdis");
        this.gZ.src = "";
        delete this.rT;
        delete this.ig
    };
    bc.cS = function (be) {
        var bh = bj.bY(be, "action");
        if (bb.cU(bh, "z-dis"))return;
        switch (bb.bz(bh, "action")) {
            case"close":
                this.bW();
                break;
            case"prev":
                this.oW(this.dR - 1);
                break;
            case"next":
                this.oW(this.dR + 1);
                break;
            case"go":
                this.oW(bb.bz(bh, "index"));
                break
        }
    };
    bc.oW = function (bv) {
        if (bv <= 0) {
            bb.bJ(this.MI, "z-cntdis")
        } else {
            bb.bH(this.MI, "z-cntdis")
        }
        if (bv >= this.ig - 1) {
            bb.bJ(this.MP, "z-cntdis")
        } else {
            bb.bH(this.MP, "z-cntdis")
        }
        if (bv < 0 || bv >= this.rT.length)return;
        var jL = this.rT[bv];
        this.ZX.href = jL + "?param=9999y9999";
        if (this.rF[bv]) {
            bb.bJ(this.Gz, "f-hide");
            this.gZ.src = jL
        } else {
            this.gZ.src = "";
            bb.bH(this.Gz, "f-hide");
            bb.bH(this.Gz, "fail-loading")
        }
        this.dR = bv
    };
    hY.imageView = function (xb, bv) {
        bT.AH.bF({parent: document.body, urls: xb, index: bv})
    };
    bc.bUa = function (be) {
        bj.cu(be);
        switch (be.keyCode) {
            case 37:
                this.oW(this.dR - 1);
                break;
            case 39:
                this.oW(this.dR + 1);
                break;
            case 27:
                this.bW();
                break;
            case 38:
                this.IM.scrollTop -= 20;
                break;
            case 40:
                this.IM.scrollTop += 20;
                break
        }
    };
    bc.bUs = function () {
        var ZF = bb.ef("input");
        this.bs.appendChild(ZF);
        ZF.focus();
        bb.dW(ZF)
    }
})();
(function () {
    var bd = NEJ.P, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), ej = bd("nej.p"), bA = bd("nej.j"), gA = bd("nm.ut"), bT = bd("nm.w"), bo = bd("nm.l"), bn = bd("nm.x"), bc, bO;
    bo.ZD = NEJ.C();
    bc = bo.ZD.bU(bo.fz);
    bO = bo.ZD.dr;
    bc.dv = function (bf) {
        bf.title = "转发动态";
        this.dC(bf)
    };
    bc.cz = function (bf) {
        if (bf.onclose === undefined) bf.onclose = function () {
            this.cw()
        }.bi(this);
        this.cB(bf);
        this.kc = bf.rid;
        this.nu = bf.uid;
        this.bTS = bf.text;
        this.gE.value = this.bTS;
        this.iI = bT.cmY.bF({parent: document.body, target: this.gE})
    };
    bc.dx = function () {
        this.dy = "m-wgt-forward"
    };
    bc.dm = function () {
        this.dw();
        var cI = bb.bP(this.bs, "j-flag");
        this.Fy = cI[0];
        this.gE = cI[1];
        this.bas = cI[2];
        this.bTR = cI[3];
        this.Hb = cI[4];
        this.jC = cI[5];
        this.brn = cI[6];
        this.bTQ = cI[7];
        this.vr = cI[8];
        bj.bt(this.gE, "input", this.iy.bi(this));
        bj.bt(this.gE, "keyup", this.bao.bi(this));
        bj.bt(this.gE, "click", this.lF.bi(this));
        bj.bt(this.Hb, "click", this.bax.bi(this));
        bj.bt(this.bTR, "click", this.bay.bi(this));
        bj.bt(this.brn, "click", this.GH.bi(this));
        bj.bt(this.bTQ, "click", this.Nk.bi(this))
    };
    bc.cR = function () {
        this.cV();
        if (this.hG) {
            this.hG.bW();
            delete this.hG
        }
        if (this.iI) {
            this.iI.bW();
            delete this.iI
        }
    };
    bc.iy = function (be) {
        ej.ek.browser == "ie" && ej.ek.version < "7.0" ? setTimeout(this.gv.bi(this), 0) : this.gv()
    };
    bc.bao = function (be) {
        this.lF();
        this.iy()
    };
    bc.gv = function () {
        var cF = this.gE.value.trim().length;
        this.jC.innerHTML = !cF ? "140" : 140 - cF;
        cF > 140 ? bb.bJ(this.jC, "s-fc6") : bb.bH(this.jC, "s-fc6");
        if (!cF || cF == 0) bb.ch(this.Fy, "display", "block"); else bb.ch(this.Fy, "display", "none")
    };
    bc.bax = function (be) {
        bj.cu(be);
        !!this.hG && this.hG.cw();
        this.iI.GY();
        this.gv()
    };
    bc.bay = function (be) {
        bj.cu(be);
        if (!this.hG) {
            this.hG = bo.DQ.bF({parent: this.bas});
            this.hG.bt("onselect", this.vG.bi(this))
        }
        this.hG.bR()
    };
    bc.vG = function (be) {
        var cm = "[" + be.text + "]";
        gA.cmS(this.gE, this.oh, cm);
        this.gv();
        bj.bK(this.gE, "keyup")
    };
    bc.lF = function () {
        this.oh = gA.sT(this.gE)
    };
    bc.GH = function (be) {
        bj.cu(be);
        if (this.eU())return;
        if (this.gE.value.trim().length > 140) {
            this.eH("字数超过140个字符");
            return
        }
        var bTB = this.gE.value.trim();
        var je = window.GUser.userId;
        var bB = this.kc;
        var bZ = "/api/event/forward";
        var bl = {forwards: bTB, id: this.kc, eventUserId: this.nu};
        bl = bm.eX(bl);
        this.eU(!0);
        var gy = bA.cG(bZ, {
            sync: false,
            type: "json",
            data: bl,
            method: "POST",
            onload: this.bhA.bi(this),
            onerror: this.cuf.bi(this)
        })
    };
    bc.bhA = function (bp) {
        this.eU(!1);
        if (bp.code != 200) {
            var cZ = "转发失败";
            switch (bp.code) {
                case 404:
                    cZ = bp.message || "该动态已被删除";
                    break;
                case 407:
                    cZ = "输入内容包含有关键字";
                    break;
                case 408:
                    cZ = "转发太快了，过会再分享吧";
                    break;
                case 315:
                    cZ = "根据对方设置，你没有该操作权限";
                    break
            }
            this.eH(cZ);
            return
        }
        gA.bAg(this.gE.value);
        this.cw();
        bo.ci.bR({tip: "转发成功！", autoclose: true});
        this.bK("onforward", {id: this.kc, eventUserId: this.nu})
    };
    bc.cuf = function (bl) {
        this.eU(!1);
        this.eH(cZ)
    };
    bc.eU = function (dI) {
        return bO.eU(this.brn, dI, "转发", "转发中 ...")
    };
    bc.eH = function (cZ) {
        return bO.eH(this.vr, cZ)
    };
    bc.Nk = function (be) {
        bj.dp(be);
        this.cw()
    };
    bc.mK = function () {
        this.gE.focus();
        if (ej.ek.browser == "ie" && parseInt(ej.ek.version) < 10)return;
        gA.Sx(this.gE, {start: 0, end: 0});
        this.lF()
    };
    bc.cw = function () {
        bO.cw.call(this);
        if (this.hG) {
            this.hG.bW();
            delete this.hG
        }
        if (this.iI) {
            this.iI.bW();
            delete this.iI
        }
    };
    bc.bR = function (bf) {
        bO.bR.call(this);
        this.eH();
        this.eU(!1);
        this.gv();
        this.mK();
        this.oh = gA.sT(this.gE)
    };
    bn.bTt = function (bf) {
        if (!GUser || !GUser.userId || GUser.userId <= 0) {
            bo.oj.bR({title: "登录"});
            return
        }
        if (bf.title === undefined) bf.title = "转发动态";
        bo.ZD.bR(bf)
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bI = bd("nej.ut"), bA = bd("nej.j"), bn = bd("nm.x"), bq = bd("nm.d"), gA = bd("nm.ut"), bo = bd("nm.l"), bc, bO;
    bo.QC = NEJ.C();
    bc = bo.QC.bU(bo.fz);
    bO = bo.QC.dr;
    bc.dv = function () {
        this.dC()
    };
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        this.hK = bk[0];
        this.beJ = bk[1];
        this.dA = bk[2];
        this.bxo = bk[3];
        this.fO = bk[4];
        bj.bt(this.bs, "click", this.fi.bi(this));
        bj.bt(this.hK, "input", this.iy.bi(this));
        bj.bt(this.hK, "keyup", this.sE.bi(this))
    };
    bc.dx = function () {
        this.dy = "m-sharesingle-layer"
    };
    bc.cz = function (bf) {
        bf.parent = bf.parent || document.body;
        bf.title = bf.title || "分享";
        bf.draggable = !0;
        bf.mask = !0;
        bf.clazz = "m-layer m-layer-w2";
        this.cB(bf);
        this.hK.value = bf.mesg || "";
        this.ck = {id: bf.rid, type: bf.type, picUrl: bf.purl, snsType: bf.snsType, resourceUrl: bf.rurl};
        if (!this.ck.resourceUrl) delete this.ck.resourceUrl;
        this.CP();
        this.eH(null);
        this.eU(false)
    };
    bc.fi = function (be) {
        var bh = bj.bY(be, "d:action"), cl = bb.bz(bh, "action");
        bj.dp(be);
        switch (cl) {
            case"txt":
                this.lF();
                break;
            case"emt":
                bj.ru(be);
                !!this.iI && this.iI.DP();
                if (!this.hG) {
                    this.hG = bo.DQ.bF({parent: this.beJ});
                    this.hG.bt("onselect", this.vG.bi(this))
                }
                this.hG.bR();
                break;
            case"ok":
                this.eH(null);
                if (this.qm)return;
                if (this.hK.value.trim().length > 140) {
                    this.eH("字数超过140个字符");
                    return
                }
                this.eU(true);
                this.ck.msg = this.hK.value;
                if (!this.ck.resourceUrl) {
                    delete this.ck.resourceUrl
                }
                bA.cG("/sns/share/resource", {
                    type: "json",
                    method: "post",
                    data: bm.eX(this.ck),
                    onload: this.tN.bi(this),
                    onerror: this.tN.bi(this)
                });
                break;
            case"cc":
                this.cw();
                break
        }
    };
    bc.vG = function (be) {
        var cm = "[" + be.text + "]";
        gA.cmS(this.hK, this.oh, cm);
        this.CP()
    };
    bc.iy = function () {
        this.CP();
        this.lF()
    };
    bc.sE = function () {
        this.CP();
        this.lF()
    };
    bc.CP = function () {
        var cF = this.hK.value.trim().length;
        this.dA.innerText = 140 - cF;
        cF > 140 ? bb.gL(this.dA, "s-fc4", "s-fc6") : bb.gL(this.dA, "s-fc6", "s-fc4")
    };
    bc.lF = function () {
        this.oh = gA.sT(this.hK)
    };
    bc.tN = function (be) {
        var iZ = {407: "输入内容包含有关键字", 404: "分享的资源不存在", 408: "分享太快了，过会再分享吧"};
        if (be.code == 200) {
            this.bK("onsuccess", be);
            if (!be.stopped) {
                bo.ci.bR({tip: "分享成功！", autoclose: true})
            }
            this.cw()
        } else {
            this.eH(iZ[be.code] || "分享失败")
        }
        this.eU(false)
    };
    bc.eH = function (Fc) {
        if (Fc) {
            this.fO.innerHTML = '<i class="u-icn u-icn-25"></i>' + Fc;
            bb.bH(this.fO, "f-hide")
        } else {
            bb.bJ(this.fO, "f-hide")
        }
    };
    bc.eU = function (bxl) {
        this.qm = bxl;
        if (bxl) {
            this.bxo.innerHTML = "<i>分享中...</i>"
        } else {
            this.bxo.innerHTML = "<i>分享</i>"
        }
    };
    bc.bR = function () {
        bO.bR.call(this);
        var gx = this.hK.value.length;
        gA.Sx(this.hK, {start: gx, end: gx, text: ""});
        this.lF()
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, cC = NEJ.F, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bI = bd("nej.ut"), bA = bd("nej.j"), bn = bd("nm.x"), bq = bd("nm.d"), hY = bd("api"), bo = bd("nm.l"), bc, bO;
    bo.bru = NEJ.C();
    bc = bo.bru.bU(bo.fz);
    bc.dm = function () {
        this.dw();
        var bk = bb.bP(this.bs, "j-flag");
        bj.bt(this.bs, "click", this.cS.bi(this))
    };
    bc.dx = function () {
        this.dy = "m-simple-share-layer"
    };
    bc.cz = function (bf) {
        bf.clazz = "m-layer-w6";
        if (!bf.shareType) bf.parent = bf.parent || document.body;
        bf.title = bf.title || "分享";
        bf.draggable = !0;
        bf.mask = bf.mask || true;
        this.cB(bf);
        this.ck = {
            id: bf.id || 0,
            type: bf.type || "activity",
            picUrl: bf.picUrl,
            msg: bf.text,
            resourceUrl: bf.resourceUrl,
            summary: bf.summary
        };
        this.dq([[window, "snsbind", this.HR.bi(this)], [window, "snsbinderror", this.cw.bi(this)]]);
        this.tO = {
            rid: this.ck.id,
            rurl: this.ck.resourceUrl,
            purl: this.ck.picUrl,
            mesg: this.ck.msg,
            type: this.ck.type,
            onsuccess: bf.onsuccess
        };
        if (bf.shareType) {
            this.brv(bf.shareType)
        }
    };
    bc.cS = function (be) {
        var bh = bj.bY(be, "d:type"), bu = bb.bz(bh, "type");
        this.brv(bu)
    };
    bc.brv = function (bu) {
        switch (bu) {
            case"xlwb":
            case"rr":
            case"db":
                var ug = {
                    xlwb: 2,
                    rr: 4,
                    db: 3
                }, Nn  = ug[bu], rc = localCache.Ol("user.bindings") || [], bv = bm.eg(rc, function (bw) {
                    return bw.type == Nn && !bw.expired
                });
                if (bv >= 0) {
                    this.wu(Nn)
                } else {
                    var kk = {
                        snsType: Nn,
                        callbackType: "Binding",
                        clientType: "web2",
                        forcelogin: true,
                        csrf_token: bA.hI("__csrf")
                    };
                    top.window.open("/api/sns/authorize?" + bm.eX(kk))
                }
                break;
            case"wx":
            case"yx":
                var kk = {resourceUrl: this.ck.resourceUrl, type: bu};
                top.open("/share/QRCode?" + bm.eX(kk));
                this.cw();
                break;
            case"qzone":
                var jF = {
                    url: this.ck.resourceUrl,
                    title: this.ck.msg || "",
                    pics: this.ck.picUrl,
                    summary: this.ck.summary
                };
                top.open("http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?" + bm.eX(jF));
                this.cw();
                break;
            case"lofter":
                var jF = {
                    from: "cloudmusic",
                    image: this.ck.picUrl,
                    source: "网易云音乐",
                    sourceurl: this.ck.resourceUrl,
                    content: this.ck.msg
                };
                top.open("http://www.lofter.com/sharephoto/?" + bm.eX(jF));
                this.cw();
                break
        }
    };
    bc.HR = function (be) {
        this.wu(be.result.type)
    };
    bc.wu = function (bu) {
        this.cw();
        if (this.wS) {
            this.wS.bW();
            delete this.wS
        }
        this.tO.snsType = bu;
        this.wS = bo.QC.bF(this.tO);
        this.wS.bR()
    };
    var dP = null;
    hY.simpleShare = function (bf) {
        if (dP) dP.bW();
        dP = bo.bru.bF(bf).bR()
    }
})();
(function () {
    var bd = NEJ.P, cg = NEJ.O, bb = bd("nej.e"), bj = bd("nej.v"), bm = bd("nej.u"), bA = bd("nej.j"), bI = bd("nej.ut"), bq = bd("nm.d"), bn = bd("nm.x"), bQ = bd("nm.m"), bo = bd("nm.l"), bL = bd("nm.m.f"), hY = bd("api"), xF = /#(.*?)$/, bc, bO, Aq = {
        pubEventWithPics: false,
        pubEventWithoutResource: false,
        pubEventWithPictureForbiddenNotice: "等级达到Lv.4，即可添加图片"
    };
    bL.brx = NEJ.C();
    bc = bL.brx.bU(bI.fb);
    bc.cY = function () {
        this.df();
        window.onHashChange = this.NM.bi(this);
        window.log = this.sy.bi(this);
        window.share = this.wu.bi(this);
        window.shareForStore = this.cjI.bi(this);
        window.subscribe = this.Uy.bi(this);
        window.onIframeClick = this.bTj.bi(this);
        bj.bt(window, "playchange", this.iH.bi(this));
        bj.bt(window, "playstatechange", this.bTh.bi(this));
        this.mT = bQ.Oi.iE();
        this.mT.bt("loginsuccess", this.bTf.bi(this));
        this.mT.bt("logoutbefore", this.Zq.bi(this));
        this.mT.bt("logoutsuccess", this.Zp.bi(this));
        this.Yf();
        this.cO = bL.KA.bF();
        this.cO.bK("onshow", {});
        bA.cG("/api/login/token/refresh", {type: "json", method: "post"});
        this.NM(bn.Ft());
        this.Nq = bQ.ZK.bF();
        hY.refreshUserInfo = this.Nq.LU.bi(this.Nq);
        this.bST();
        hY.cbDonate = this.bSN;
        var referrer = document.referrer;
        if (referrer.indexOf(location.hostname) === -1) {
            var conf = {is_organic: referrer ? 0 : 1, url: location.href};
            if (!conf.is_organic) {
                conf.source = referrer
            }
            this.sy("activeweb", conf)
        }
    };
    bc.Yf = function () {
        this.kF = bq.kQ.bF()
    };
    bc.NM = function (fA) {
        var be = location.parse(fA);
        this.pH(be)
    };
    bc.pH = function (be, bu) {
        var fU = bb.bG("g_iframe"), lq = be.path, cN = be.query, jq = fU.contentWindow.location;
        this.xJ = fU;
        if (/^\/mv/.test(lq)) {
            if (this.cO) this.cO.cw();
            this.kG = document.title
        } else {
            if (this.cO) this.cO.bR();
            document.title = this.kG || bn.qc()
        }
        if (cN.play == "true" && /^\/(m\/)?song/.test(lq)) {
            if (this.cO) this.cO.Iq(18, cN.id, true)
        }
        if (/^\/my\/m\/music\/playlist/.test(lq)) {
            var yh = bn.Qh();
            if (!yh && !!cN.id)return location.dispatch2("/playlist?id=" + cN.id)
        }
        if (/^\/login\b/.test(lq) && GUser && GUser.userId) {
            var vZ = /targetUrl=(.+?)(&|$)/.exec(be.href), ctA = vZ ? decodeURIComponent(vZ[1]) : "/discover";
            ctA = ctA.replace("/m/", "/#/");
            ctA = ctA.replace(/^\s+|\s+$/g, "");
            var eh = /^https?:\/\//i, HF = /^\/\//, bZJ = /^\//;
            if (!eh.test(ctA) && !HF.test(ctA) && !bZJ.test(ctA)) {
                ctA = "/discover"
            }
            return location.href = encodeURI(ctA)
        }
        if (bu !== undefined) {
            if (cN && cN.targetUrl) {
                var Tx = location.parse(cN.targetUrl);
                if (Tx.path.indexOf("/store/") == 0 || Tx.path.indexOf("/nmusician/") == 0) {
                    return location.href = be.href
                }
            }
            return GDispatcher.refreshIFrame(be.href)
        }
    };
    bc.bTf = function () {
        var fA = xF.test(location.href) ? RegExp.$1 : "", be = location.parse(fA), brJ = this.Nq;
        brJ.LU();
        bA.cG("/api/topic/user/info", {
            type: "json", onload: function (hy) {
                top.GUserAcc = NEJ.X(top.GUserAcc || {}, {topic: hy.status});
                brJ.LU()
            }
        });
        bA.cG("/api/reward/user/showicon", {
            type: "json", onload: function (hy) {
                top.GUserAcc = NEJ.X(top.GUserAcc || {}, {reward: hy.showIcon});
                brJ.LU()
            }
        });
        if (!hY.sharePermission) {
            hY.sharePermission = Aq
        }
        bA.cG("/api/event/user/permission", {
            type: "json", onload: function (be) {
                if (be.code == 200) {
                    hY.sharePermission = NEJ.EX(Aq, be)
                }
            }
        });
        this.pH(be, "urlchange")
    };
    bc.Zq = function () {
        bo.ve.cw();
        this.Nq.LU()
    };
    bc.Zp = function () {
        if (!location.hash || location.hash == "#") {
            var fA = xF.test(location.href) ? RegExp.$1 : "", be = location.parse(fA);
            this.pH(be, "urlchange");
            return
        }
        location.hash = "#"
    };
    bc.iH = function (be) {
        if (this.xJ) {
            var dB = this.xJ.contentWindow;
            try {
                if (dB.nej && dB.nej.v) {
                    dB.nej.v.bK ? dB.nej.v.bK(dB, "playchange", be) : dB.nej.v.dispatchEventalias ? dB.nej.v.dispatchEventalias(dB, "playchange", be) : ""
                }
            } catch (e) {
            }
        }
    };
    bc.bTh = function (be) {
        if (!this.xJ)return;
        var dB = this.xJ.contentWindow;
        try {
            if (dB.nej && dB.nej.v) {
                dB.nej.v.bK ? dB.nej.v.bK(dB, "playstatechange", be) : dB.nej.v.dispatchEventalias ? dB.nej.v.dispatchEventalias(dB, "playstatechange", be) : ""
            }
        } catch (e) {
        }
    };
    bc.sy = function (cl, cj) {
        switch (cl) {
            case"play":
                this.kF.hj(cj);
                break;
            case"search":
                this.kF.bsH(cj);
                break;
            default:
                this.kF.mW(cl, cj)
        }
    };
    bc.wu = function () {
        if (this.xJ.contentWindow.share) {
            this.xJ.contentWindow.share.apply(this.xJ.contentWindow, arguments)
        }
    };
    bc.cjI = function () {
        var bJL = function (be) {
            bj.bK(window, "share", be)
        };
        return function (dO, bu, IC, bX, bgm, bgn) {
            bn.sd({rid: dO, type: bu, purl: IC, name: bX, author: bgm, authors: bgn, onshare: bJL.bi(this)})
        }
    }();
    bc.Uy = function (cJ, bSB) {
        var dB = this.xJ.contentWindow;
        if (dB.nm && dB.nm.x) {
            if (!dB.nm.x.lP) {
                dB = top.window
            }
            if (bSB && dB.nm.x.btz) {
                dB.nm.x.btz({data: cJ.program})
            } else if (dB.nm.x.lP) {
                var bk = bm.hh(cJ) ? cJ : [cJ];
                dB.nm.x.lP({tracks: bk})
            }
        }
    };
    bc.bTj = function (be) {
        bj.bK(window, "iframeclick")
    };
    bc.bST = function () {
        bA.cG("/api/copyright/pay_fee_message/config", {
            type: "json", onload: function (be) {
                if (be.code == 200) {
                    hY.feeMessage = be.config
                }
            }
        });
        hY.sharePermission = Aq;
        bA.cG("/api/event/user/permission", {
            type: "json", onload: function (be) {
                if (be.code == 200) {
                    hY.sharePermission = NEJ.EX(Aq, be)
                }
            }
        })
    };
    bc.bSN = function () {
        var dG = {jst: "m-wgt-redeem-tip", clazz: "n-redeem"};
        dG.data = {title: "成功送出", sub: "请你的好友去查看私信", ok: "知道了", type: "success"};
        dG.onaction = function () {
            location.dispatch2("/member")
        };
        bn.lg(dG)
    };
    window.doMsgToServiceAction = bc.cek = function () {
        var NG = null;
        return function (cl) {
            if (cl == "kf") {
                NG && NG.bW();
                NG = bo.cna.bF({
                    title: "发新私信",
                    draggable: true,
                    clazz: "m-layer m-layer-w2",
                    receiver: {userId: bn.bvk() ? 117863002 : 253335632, nickname: bn.bvk() ? "测试库客服" : "云音乐客服"}
                });
                NG.bR()
            }
        }
    }();
    bI.gN.bF({element: window, event: ["playchange", "iframeclick", "playstatechange"]});
    bb.dV("template-box");
    new bL.brx
})()