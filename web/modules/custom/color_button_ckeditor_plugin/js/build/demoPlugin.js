!function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.CKEditor5=t():(e.CKEditor5=e.CKEditor5||{},e.CKEditor5.demoPlugin=t())}(self,(()=>(()=>{var e={"ckeditor5/src/core.js":(e,t,n)=>{e.exports=n("dll-reference CKEditor5.dll")("./src/core.js")},"ckeditor5/src/ui.js":(e,t,n)=>{e.exports=n("dll-reference CKEditor5.dll")("./src/ui.js")},"dll-reference CKEditor5.dll":e=>{"use strict";e.exports=CKEditor5.dll}},t={};function n(l){var i=t[l];if(void 0!==i)return i.exports;var o=t[l]={exports:{}};return e[l](o,o.exports,n),o.exports}n.d=(e,t)=>{for(var l in t)n.o(t,l)&&!n.o(e,l)&&Object.defineProperty(e,l,{enumerable:!0,get:t[l]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t);var l={};return(()=>{"use strict";n.d(l,{default:()=>c});var e=n("ckeditor5/src/core.js");class t extends e.Command{execute(e,t,n,l){const{model:i}=this.editor;i.change((o=>{const s=o.createElement("linkPlugin"),r=o.createElement("linkContent");o.append(e,r),o.setAttribute("href",t,s),o.setAttribute("style",`color: ${n}; background-color: ${l};`,r),o.append(r,s),i.insertContent(s)}))}refresh(){const{model:e}=this.editor,{selection:t}=e.document,n=e.schema.findAllowedParent(t.getFirstPosition(),"linkPlugin");this.isEnabled=null!==n}}class i extends e.Plugin{init(){this._defineSchema(),this._defineConverters(),this.editor.commands.add("insertLinkPlugin",new t(this.editor))}_defineSchema(){const e=this.editor.model.schema;e.register("linkPlugin",{isObject:!0,allowWhere:"$block",allowAttributes:["href"]}),e.register("linkContent",{isLimit:!0,allowIn:"linkPlugin",allowContentOf:"$block",allowAttributes:["color","bgColor","style"]})}_defineConverters(){const{conversion:e}=this.editor;e.for("upcast").attributeToAttribute({model:"linkPlugin",view:{name:"a",classes:"link-plugin"}}),e.for("upcast").elementToElement({model:"linkContent",view:{name:"span",classes:"link-content"}}),e.for("downcast").elementToElement({model:"linkPlugin",view:(e,{writer:t})=>t.createEditableElement("a",{href:e.getAttribute("href"),class:"link-plugin"})}),e.for("downcast").elementToElement({model:"linkContent",view:(e,{writer:t})=>t.createEditableElement("span",{class:"link-content",style:e.getAttribute("style")})})}}var o=n("ckeditor5/src/ui.js");class s{constructor(e,t){this.editor=e,this.defaultColor=t}openModal(){const e=document.querySelector(".modal");if(e)return void(e.style.display="block"===e.style.display?"none":"block");const t=document.createElement("div");t.classList.add("modal");const n=document.createElement("div");n.classList.add("modal-content"),n.style.display="flex",n.style.flexDirection="column",n.style.position="relative";const l=document.createElement("span");l.classList.add("close"),l.textContent="×",l.addEventListener("click",(()=>{t.style.display="none"}));const i=document.createElement("input");i.setAttribute("type","text"),i.setAttribute("placeholder","Enter title"),i.id="linkTitle";const o=document.createElement("input");o.setAttribute("type","text"),o.setAttribute("placeholder","Enter URL"),o.id="linkURL";const s=document.createElement("input");s.setAttribute("type","color"),s.id="textColor",s.setAttribute("placeholder","#000"),s.style.height="15px";const r=document.createElement("input");r.setAttribute("type","color"),r.id="bgColor",r.setAttribute("value",this.defaultColor),r.style.height="15px";const d=document.createElement("button");d.textContent="Save",d.addEventListener("click",(e=>{e.preventDefault();const n=document.getElementById("linkTitle").value,l=document.getElementById("linkURL").value,d=document.getElementById("textColor").value,c=document.getElementById("bgColor").value;this.insertLink(n,l,d,c),i.value="",o.value="",s.value="#000000",r.value="#FFFFFF",t.style.display="none"})),n.appendChild(l),n.appendChild(i),n.appendChild(o),n.appendChild(s),n.appendChild(r),n.appendChild(d),t.appendChild(n);const c=document.querySelector(".ck-editor__top");c&&c.appendChild(t),t.style.display="block"}insertLink(e,t,n,l){const i=this.editor.commands.get("insertLinkPlugin"),o=t.startsWith("http")?t:`http://${t}`;i.execute(e,o,n,l)}}class r extends e.Plugin{init(){const e=this.editor,t=e.config.get("default_color");e.ui.componentFactory.add("linkPlugin",(n=>{const l=e.commands.get("insertLinkPlugin"),i=new o.ButtonView(n);return i.set({label:e.t("Styled link"),tooltip:!0,icon:'<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.95154 2.84131C1.95154 2.28902 2.39925 1.84131 2.95154 1.84131H17.0484C17.6007 1.84131 18.0484 2.28902 18.0484 2.84131V17.1588C18.0484 17.7111 17.6007 18.1588 17.0484 18.1588H2.95154C2.39925 18.1588 1.95154 17.7111 1.95154 17.1588V2.84131ZM3.5116 8.10129H16.4926V15.3194C16.4926 15.8717 16.0449 16.3194 15.4926 16.3194H4.5116C3.95931 16.3194 3.5116 15.8717 3.5116 15.3194V8.10129ZM4.44415 3.81676C3.89187 3.81676 3.44415 4.26447 3.44415 4.81676V6.35087H16.4316V4.81676C16.4316 4.26447 15.9838 3.81676 15.4316 3.81676H4.44415Z" fill="black"/></svg>\n'}),i.bind("isOn","isEnabled").to(l,"value","isEnabled"),this.listenTo(i,"execute",(()=>{new s(e,t).openModal()})),i}))}}class d extends e.Plugin{static get requires(){return[i,r]}}const c={LinkPlugin:d}})(),l=l.default})()));