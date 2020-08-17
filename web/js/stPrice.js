/* big.js v3.1.3 https://github.com/MikeMcl/big.js/LICENCE */(function(global){"use strict";var DP=20,RM=1,MAX_DP=1e6,MAX_POWER=1e6,E_NEG=-7,E_POS=21,P={},isValid=/^-?(\d+(\.\d*)?|\.\d+)(e[+-]?\d+)?$/i,Big;function bigFactory(){function Big(n){var x=this;if(!(x instanceof Big)){return n===void 0?bigFactory():new Big(n)}if(n instanceof Big){x.s=n.s;x.e=n.e;x.c=n.c.slice()}else{parse(x,n)}x.constructor=Big}Big.prototype=P;Big.DP=DP;Big.RM=RM;Big.E_NEG=E_NEG;Big.E_POS=E_POS;return Big}function format(x,dp,toE){var Big=x.constructor,i=dp-(x=new Big(x)).e,c=x.c;if(c.length>++dp){rnd(x,i,Big.RM)}if(!c[0]){++i}else if(toE){i=dp}else{c=x.c;i=x.e+i+1}for(;c.length<i;c.push(0)){}i=x.e;return toE===1||toE&&(dp<=i||i<=Big.E_NEG)?(x.s<0&&c[0]?"-":"")+(c.length>1?c[0]+"."+c.join("").slice(1):c[0])+(i<0?"e":"e+")+i:x.toString()}function parse(x,n){var e,i,nL;if(n===0&&1/n<0){n="-0"}else if(!isValid.test(n+="")){throwErr(NaN)}x.s=n.charAt(0)=="-"?(n=n.slice(1),-1):1;if((e=n.indexOf("."))>-1){n=n.replace(".","")}if((i=n.search(/e/i))>0){if(e<0){e=i}e+=+n.slice(i+1);n=n.substring(0,i)}else if(e<0){e=n.length}for(i=0;n.charAt(i)=="0";i++){}if(i==(nL=n.length)){x.c=[x.e=0]}else{for(;n.charAt(--nL)=="0";){}x.e=e-i-1;x.c=[];for(e=0;i<=nL;x.c[e++]=+n.charAt(i++)){}}return x}function rnd(x,dp,rm,more){var u,xc=x.c,i=x.e+dp+1;if(rm===1){more=xc[i]>=5}else if(rm===2){more=xc[i]>5||xc[i]==5&&(more||i<0||xc[i+1]!==u||xc[i-1]&1)}else if(rm===3){more=more||xc[i]!==u||i<0}else{more=false;if(rm!==0){throwErr("!Big.RM!")}}if(i<1||!xc[0]){if(more){x.e=-dp;x.c=[1]}else{x.c=[x.e=0]}}else{xc.length=i--;if(more){for(;++xc[i]>9;){xc[i]=0;if(!i--){++x.e;xc.unshift(1)}}}for(i=xc.length;!xc[--i];xc.pop()){}}return x}function throwErr(message){var err=new Error(message);err.name="BigError";throw err}P.abs=function(){var x=new this.constructor(this);x.s=1;return x};P.cmp=function(y){var xNeg,x=this,xc=x.c,yc=(y=new x.constructor(y)).c,i=x.s,j=y.s,k=x.e,l=y.e;if(!xc[0]||!yc[0]){return!xc[0]?!yc[0]?0:-j:i}if(i!=j){return i}xNeg=i<0;if(k!=l){return k>l^xNeg?1:-1}i=-1;j=(k=xc.length)<(l=yc.length)?k:l;for(;++i<j;){if(xc[i]!=yc[i]){return xc[i]>yc[i]^xNeg?1:-1}}return k==l?0:k>l^xNeg?1:-1};P.div=function(y){var x=this,Big=x.constructor,dvd=x.c,dvs=(y=new Big(y)).c,s=x.s==y.s?1:-1,dp=Big.DP;if(dp!==~~dp||dp<0||dp>MAX_DP){throwErr("!Big.DP!")}if(!dvd[0]||!dvs[0]){if(dvd[0]==dvs[0]){throwErr(NaN)}if(!dvs[0]){throwErr(s/0)}return new Big(s*0)}var dvsL,dvsT,next,cmp,remI,u,dvsZ=dvs.slice(),dvdI=dvsL=dvs.length,dvdL=dvd.length,rem=dvd.slice(0,dvsL),remL=rem.length,q=y,qc=q.c=[],qi=0,digits=dp+(q.e=x.e-y.e)+1;q.s=s;s=digits<0?0:digits;dvsZ.unshift(0);for(;remL++<dvsL;rem.push(0)){}do{for(next=0;next<10;next++){if(dvsL!=(remL=rem.length)){cmp=dvsL>remL?1:-1}else{for(remI=-1,cmp=0;++remI<dvsL;){if(dvs[remI]!=rem[remI]){cmp=dvs[remI]>rem[remI]?1:-1;break}}}if(cmp<0){for(dvsT=remL==dvsL?dvs:dvsZ;remL;){if(rem[--remL]<dvsT[remL]){remI=remL;for(;remI&&!rem[--remI];rem[remI]=9){}--rem[remI];rem[remL]+=10}rem[remL]-=dvsT[remL]}for(;!rem[0];rem.shift()){}}else{break}}qc[qi++]=cmp?next:++next;if(rem[0]&&cmp){rem[remL]=dvd[dvdI]||0}else{rem=[dvd[dvdI]]}}while((dvdI++<dvdL||rem[0]!==u)&&s--);if(!qc[0]&&qi!=1){qc.shift();q.e--}if(qi>digits){rnd(q,dp,Big.RM,rem[0]!==u)}return q};P.eq=function(y){return!this.cmp(y)};P.gt=function(y){return this.cmp(y)>0};P.gte=function(y){return this.cmp(y)>-1};P.lt=function(y){return this.cmp(y)<0};P.lte=function(y){return this.cmp(y)<1};P.sub=P.minus=function(y){var i,j,t,xLTy,x=this,Big=x.constructor,a=x.s,b=(y=new Big(y)).s;if(a!=b){y.s=-b;return x.plus(y)}var xc=x.c.slice(),xe=x.e,yc=y.c,ye=y.e;if(!xc[0]||!yc[0]){return yc[0]?(y.s=-b,y):new Big(xc[0]?x:0)}if(a=xe-ye){if(xLTy=a<0){a=-a;t=xc}else{ye=xe;t=yc}t.reverse();for(b=a;b--;t.push(0)){}t.reverse()}else{j=((xLTy=xc.length<yc.length)?xc:yc).length;for(a=b=0;b<j;b++){if(xc[b]!=yc[b]){xLTy=xc[b]<yc[b];break}}}if(xLTy){t=xc;xc=yc;yc=t;y.s=-y.s}if((b=(j=yc.length)-(i=xc.length))>0){for(;b--;xc[i++]=0){}}for(b=i;j>a;){if(xc[--j]<yc[j]){for(i=j;i&&!xc[--i];xc[i]=9){}--xc[i];xc[j]+=10}xc[j]-=yc[j]}for(;xc[--b]===0;xc.pop()){}for(;xc[0]===0;){xc.shift();--ye}if(!xc[0]){y.s=1;xc=[ye=0]}y.c=xc;y.e=ye;return y};P.mod=function(y){var yGTx,x=this,Big=x.constructor,a=x.s,b=(y=new Big(y)).s;if(!y.c[0]){throwErr(NaN)}x.s=y.s=1;yGTx=y.cmp(x)==1;x.s=a;y.s=b;if(yGTx){return new Big(x)}a=Big.DP;b=Big.RM;Big.DP=Big.RM=0;x=x.div(y);Big.DP=a;Big.RM=b;return this.minus(x.times(y))};P.add=P.plus=function(y){var t,x=this,Big=x.constructor,a=x.s,b=(y=new Big(y)).s;if(a!=b){y.s=-b;return x.minus(y)}var xe=x.e,xc=x.c,ye=y.e,yc=y.c;if(!xc[0]||!yc[0]){return yc[0]?y:new Big(xc[0]?x:a*0)}xc=xc.slice();if(a=xe-ye){if(a>0){ye=xe;t=yc}else{a=-a;t=xc}t.reverse();for(;a--;t.push(0)){}t.reverse()}if(xc.length-yc.length<0){t=yc;yc=xc;xc=t}a=yc.length;for(b=0;a;){b=(xc[--a]=xc[a]+yc[a]+b)/10|0;xc[a]%=10}if(b){xc.unshift(b);++ye}for(a=xc.length;xc[--a]===0;xc.pop()){}y.c=xc;y.e=ye;return y};P.pow=function(n){var x=this,one=new x.constructor(1),y=one,isNeg=n<0;if(n!==~~n||n<-MAX_POWER||n>MAX_POWER){throwErr("!pow!")}n=isNeg?-n:n;for(;;){if(n&1){y=y.times(x)}n>>=1;if(!n){break}x=x.times(x)}return isNeg?one.div(y):y};P.round=function(dp,rm){var x=this,Big=x.constructor;if(dp==null){dp=0}else if(dp!==~~dp||dp<0||dp>MAX_DP){throwErr("!round!")}rnd(x=new Big(x),dp,rm==null?Big.RM:rm);return x};P.sqrt=function(){var estimate,r,approx,x=this,Big=x.constructor,xc=x.c,i=x.s,e=x.e,half=new Big("0.5");if(!xc[0]){return new Big(x)}if(i<0){throwErr(NaN)}i=Math.sqrt(x.toString());if(i===0||i===1/0){estimate=xc.join("");if(!(estimate.length+e&1)){estimate+="0"}r=new Big(Math.sqrt(estimate).toString());r.e=((e+1)/2|0)-(e<0||e&1)}else{r=new Big(i.toString())}i=r.e+(Big.DP+=4);do{approx=r;r=half.times(approx.plus(x.div(approx)))}while(approx.c.slice(0,i).join("")!==r.c.slice(0,i).join(""));rnd(r,Big.DP-=4,Big.RM);return r};P.mul=P.times=function(y){var c,x=this,Big=x.constructor,xc=x.c,yc=(y=new Big(y)).c,a=xc.length,b=yc.length,i=x.e,j=y.e;y.s=x.s==y.s?1:-1;if(!xc[0]||!yc[0]){return new Big(y.s*0)}y.e=i+j;if(a<b){c=xc;xc=yc;yc=c;j=a;a=b;b=j}for(c=new Array(j=a+b);j--;c[j]=0){}for(i=b;i--;){b=0;for(j=a+i;j>i;){b=c[j]+yc[i]*xc[j-i-1]+b;c[j--]=b%10;b=b/10|0}c[j]=(c[j]+b)%10}if(b){++y.e}if(!c[0]){c.shift()}for(i=c.length;!c[--i];c.pop()){}y.c=c;return y};P.toString=P.valueOf=P.toJSON=function(){var x=this,Big=x.constructor,e=x.e,str=x.c.join(""),strL=str.length;if(e<=Big.E_NEG||e>=Big.E_POS){str=str.charAt(0)+(strL>1?"."+str.slice(1):"")+(e<0?"e":"e+")+e}else if(e<0){for(;++e;str="0"+str){}str="0."+str}else if(e>0){if(++e>strL){for(e-=strL;e--;str+="0"){}}else if(e<strL){str=str.slice(0,e)+"."+str.slice(e)}}else if(strL>1){str=str.charAt(0)+"."+str.slice(1)}return x.s<0&&x.c[0]?"-"+str:str};P.toExponential=function(dp){if(dp==null){dp=this.c.length-1}else if(dp!==~~dp||dp<0||dp>MAX_DP){throwErr("!toExp!")}return format(this,dp,1)};P.toFixed=function(dp){var str,x=this,Big=x.constructor,neg=Big.E_NEG,pos=Big.E_POS;Big.E_NEG=-(Big.E_POS=1/0);if(dp==null){str=x.toString()}else if(dp===~~dp&&dp>=0&&dp<=MAX_DP){str=format(x,x.e+dp);if(x.s<0&&x.c[0]&&str.indexOf("-")<0){str="-"+str}}Big.E_NEG=neg;Big.E_POS=pos;if(!str){throwErr("!toFix!")}return str};P.toPrecision=function(sd){if(sd==null){return this.toString()}else if(sd!==~~sd||sd<1||sd>MAX_DP){throwErr("!toPre!")}return format(this,sd-1,2)};Big=bigFactory();if(typeof define==="function"&&define.amd){define(function(){return Big})}else if(typeof module!=="undefined"&&module.exports){module.exports=Big}else{global.Big=Big}})(this);

function stPrice() {}

function stPriceTaxManagment(params)
{
   this.initialize = function(params)
   {
      this.priceFields = [];

      this.addParams = params.params;

      if (params.taxField != undefined)
      {
         this.taxField = $(params.taxField);

         this.taxField.observe('change', this.taxFieldListener.bind(this));

         this.taxValues = params.taxValues;
      }
      else if (params.taxValue != undefined)
      {
         this.taxValue = params.taxValue;
      }
      else
      {
         throw "Missing parameters {taxField: field_id, taxValues: [value1, value2, ...]} or {taxValue: value}";
      }

      this.params = params;

      params.priceFields.each(this.initializePriceField.bind(this));
   }

   this.addPriceField = function(field)
   {
      var index = this.priceFields.length;

      this.initializePriceField(field, index);
   }

   this.disablePriceFields = function()
   {
      this.priceFields.each(function (f)
      {
         f.price.disable();
      });
   }

   this.enablePriceFields = function()
   {
      this.priceFields.each(function (f)
      {
         f.price.enable();
      });
   }

   this.disablePriceWithTaxFields = function()
   {
      this.priceFields.each(function (f)
      {
         f.priceWithTax.disable();
      });
   }

   this.refreshPriceFields = function()
   {
      var instance = this;

      this.priceFields.each(function (f)
      {
         instance.updatePriceByPriceWithTaxField(f.price, f.priceWithTax);
      });
   }

   this.refreshPriceWithTaxFields = function()
   {
      var instance = this;

      this.priceFields.each(function (f)
      {
         instance.updatePriceWithTaxByPriceField(f.price, f.priceWithTax);
      });
   }

   this.enablePriceWithTaxFields = function()
   {
      this.priceFields.each(function (f)
      {
         f.priceWithTax.enable();
      });
   }

   this.initializePriceField = function(fields, index)
   {
      if (!$(fields.price))
      {
         window.alert('Field "'+fields.price+'" does not exist');
      }      
      
      fields.price = $(fields.price);
      
      if (!$(fields.priceWithTax))
      {
         window.alert('Field "'+fields.priceWithTax+'" does not exist');
      }          
      
      fields.priceWithTax = $(fields.priceWithTax);

      fields.price.dependency = fields.priceWithTax;

      fields.priceWithTax.dependency = fields.price;

      fields.price.observe('change', this.priceFieldListener.bind(this));

      fields.priceWithTax.observe('change', this.priceWithTaxFieldListener.bind(this));

      fields.price.observe('keypress', this.priceFieldListener.bind(this));

      fields.priceWithTax.observe('keypress', this.priceWithTaxFieldListener.bind(this));

      this.priceFields[index] = fields;
   }

   this.updatePriceWithTaxByPriceField = function(priceField, priceWithTaxField)
   {
      priceField.value = stPrice.fixNumberFormat(priceField.value);

      var price = stPrice.calculate(priceField.value, this.currentTaxValue());

      stPrice.updateField(priceWithTaxField, price);
   }

   this.updatePriceByPriceWithTaxField = function(priceField, priceWithTaxField)
   {
      priceWithTaxField.value = stPrice.fixNumberFormat(priceWithTaxField.value);
      
      var price = stPrice.extract(priceWithTaxField.value, this.currentTaxValue());

      stPrice.updateField(priceField, price);
   }

   this.taxFieldListener = function()
   {
      var instance = this;

      this.priceFields.each(function (f)
      {
         if (f.price.disabled == false)
         {
            instance.updatePriceWithTaxByPriceField(f.price, f.priceWithTax);

            if (instance.params.onChange)
            {
               instance.params.onChange(f.price, f.priceWithTax, this.taxField, this.addParams);
            }
         }
      });
   }

   this.priceFieldListener = function(event)
   {
      if (event.type == 'change' ||  event.type == 'keypress' && event.keyCode == 13)
      {
//         Event.stop(event);

         var priceField = event.element();

         this.updatePriceWithTaxByPriceField(priceField, priceField.dependency);

         if (this.params.onChange)
         {
            this.params.onChange(priceField, priceField.dependency, this.taxField, this.addParams);
         }
      }
   }

   this.priceWithTaxFieldListener = function(event)
   {
      if (event.type == 'change' ||  event.type == 'keypress' && event.keyCode == 13)
      {
//         Event.stop(event);

         var priceField = event.element();

         this.updatePriceByPriceWithTaxField(priceField.dependency, priceField);

         if (this.params.onChange)
         {
            this.params.onChange(priceField.dependency, priceField, this.taxField, this.addParams);
         }
      }
   }

   this.currentTaxValue = function()
   {
      return this.taxValue != undefined ? this.taxValue : this.taxValues[this.taxField.selectedIndex];
   }

   this.initialize(params);
}

stPrice.updateField = function(field, value, update_disabled)
{
   field = $(field);

   if ((field.disabled == false || update_disabled) && field.value != value)
   {
      field.value = value;

      var prev_color = field.readAttribute('prev-background-color');

      if (!prev_color)
      {
         prev_color = field.getStyle('background-color');

         field.setAttribute('prev-background-color', prev_color);
      }

      new Effect.Highlight(field, {
         startcolor: '#ffff99',
         endcolor: prev_color.parseColor(),
         restorecolor: prev_color.parseColor(),
         duration: 0.8
      });
   }
}

stPrice.calculate = function(price, tax)
{
   return stPrice.round(Number(price) * (1 + Number(tax) * 0.01));
}

stPrice.applyExchange = function(price, exchange)
{
   return price / exchange;
}

stPrice.extractExchange = function(price, exchange)
{
   return price * exchange;
}

stPrice.extract = function(price_with_tax, tax)
{
   return stPrice.round(price_with_tax / (1 + tax * 0.01));
}

stPrice.applyDiscount = function(price, discount)
{
   return stPrice.round(price * (1 - discount * 0.01));
}

stPrice.round = function(price, precision)
{
   var decimal = new Big(price);

   return decimal.toFixed(precision !== undefined ? precision : 2);
}

stPrice.fixNumberFormat = function(number, precision, maxlength)
{
   if (maxlength == undefined)
   {
      maxlength = 11;
   }
   
   number = number.replace(',', '.');

   number = number.split('.', 2);
   
   number[0] = number[0].slice(0, maxlength-3);

   number = number.join('.').replace(/[^0-9\.]/ig,'');

   return stPrice.round(number, precision);
}

stPrice.addFormatBehavior = function(field, precision, maxlength)
{
   $(field).observe('change', function() {
      this.value = stPrice.fixNumberFormat(this.value, precision, maxlength);
   });
}