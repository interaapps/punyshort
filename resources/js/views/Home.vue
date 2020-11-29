<template>
    <div>
        <div id="top-section">
            <div id="shorten" :class="{'more-options': expanded}">
                <input v-model="link" type="text" placeholder="Link in here" id="shorten-link">
                <svg @click="expanded = !expanded" :style="{transform: expanded ? 'rotate(180deg)' : ''}" id="expand-button" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>
                <div id="expand">
                    <select v-model="domain" id="domain">
                        <option v-for="(alias, domain) in $store.state.domains" :key="domain.name" :value="domain">{{alias.name}}</option>
                    </select>
                    <input v-if="$store.state.domains[domain] ? $store.state.domains[domain].isPublic == '0' : false" v-model="customURL" type="text" placeholder="Custom url" id="shorten-url">
                </div>
                <a id="shorten-button" class="button" @click="shorten">shorten</a>
            </div>
            <div id="result" v-if="outputUrl != null">
                <input ref="urlOutput" type="text" :value="outputUrl" id="url" readonly>
                <router-link :to="statsLink" class="button">stats</router-link>
                <a class="button" @click="copy">copy</a>
            </div>
            <div id="error" v-if="error != null">
                {{error}}
            </div>
        </div>

        <div style="width: 100%; background: #141646; padding: 20px 0px;">
            <h1 style="text-align: center; color: #FFFFFF; display: block; margin: 30px 0px;">Features</h1>
            <div id="features-list">
                <div style="margin-top: 45px;">
                    <img src="/assets/images/illustrations/domains.svg">
                    <h5>Custom Brand URLs</h5>
                    <span>Use your own domain to create custom shorten urls like go.interaapps.de/donate</span>
                </div>
                <div>
                    <img src="/assets/images/illustrations/stats.svg">
                    <h5>Statistics</h5>
                    <span>Track the non-user-specific data like the date when he visited, the browser, the estimated country and operating system.</span>
                </div>
                <div style="margin-top: 15px;">
                    <img src="/assets/images/illustrations/socialgrowth.svg">
                    <h5>Share</h5>
                    <span>Share it on social media and get better results. People do more often click on shorten links.</span>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data(){return{
        link: "",
        domain: "pnsh.ga",
        expanded: false,
        customURL: "",
        statsLink: "/links",
        outputUrl: null,
        error: null
    }},
    methods: {
        shorten(){
            this.punyshortClient.post("api/v2/short?domain="+this.domain, {
                link: this.link,
                name: this.customURL
            })
                .then(res=>res.json())
                .then(res=>{
                    if (res.error == 0) {
                        this.statsLink= "/links/"+encodeURIComponent(res.link)+"?domain="+this.domain;
                        this.outputUrl = res.full_link;
                        this.error = null;
                        this.punyshortClient.get("user/links")
                            .then(res=>{
                                this.$store.state.links = res.json()
                            })
                    } else {
                        if (res.error == 1 || res.error == 2)
                            this.error = "Please enter a valid URL. (Including https://)";
                        else if (res.error == 3)
                            this.error = "Internal error!";
                        else if (res.error == 4)
                            this.error = "You can't use a customURL twice!";
                    }
                })
        },
        copy(){
            this.$refs.urlOutput.select()
            document.execCommand("copy")
        }
    }
}
</script>
<style lang="scss">
#top-section {
    background: #0D0F3B;
    padding: 230px 10px 230px 10px;
    #shorten {
        margin: auto;
        height: 50px;
        max-width: 900px;
        border-radius: 6.5px;
        background: #FFF;
        color: #444444;
        #shorten-link {
            border: none;
            outline: none;
            height: 50px;
            width: calc(100% - 100px - 40px);
            padding: 10px;
            padding-left: 17px;
            background: #FFFFFF;
            border-radius: 6.5px 0px 0px 6.5px;
            font-size: 16px;
        }
        #expand-button {
            width:  24px;
            height: 24px;
            margin-right: 8px;
            cursor: pointer;
            vertical-align: middle;
            transform: rotate(0deg);
            transition: 0.3s;
        }

        #expand {
            display: none;
        }
        
        #domain {
            border: none;
            outline: none;
            height: 50px;
            background: transparent;
            width: 85px;
        }
        #shorten-url {
            border: none;
            outline: none;
            height: 50px;
            background: #FFFFFF;
        }
        #shorten-button {
            
        }

        &.more-options {
            height: fit-content;
            padding-bottom: 5.5px;
            #shorten-link {
                width: calc(100% - 40px);
                font-size: 17px;
            }
            #expand {
                display: block;
            }
            #domain {
                width: 200px;
                margin-left: 13px;
                font-size: 15px;
            }
            #shorten-url {
                width: calc(100% - 224px);
                padding-left: 20px;
                font-size: 15px;
            }
            #shorten-button {
                display: block;
                width: calc(100% - 10px);
                margin: auto;
                margin-top: 20px;
            }

        }
    }

    #result {
        margin: auto;
        height: 50px;
        max-width: 900px;
        border-radius: 6.5px;
        background: #FFF;
        margin-top: 20px;

        #url {
            line-height: 50px;
            width: calc(100% - 204px);
            display: inline-block;
            padding-left: 20px;
            overflow: hidden;
            font-size: 16px;
            border: none;
            outline: none;
            background: transparent;
        }
    }

    #error {
        margin: auto;
        height: 50px;
        max-width: 900px;
        border-radius: 6.5px;
        margin-top: 20px;
        line-height: 50px;
        font-size: 18px;
        padding-left: 14px;
        background: #ec4d4d;
        color: #FFFFFF;
    }
}

#features-list {
    display: flex;
    width: fit-content;
    margin: auto;
    font-family: Jost, sans-serif;
}

#features-list div {
    display: block;
    margin: 0px 30px;
    text-align: center;
    color: #FFFFFF;
    text-decoration: none;
    padding: 10px 20px;
    width: 250px;
}

#features-list div img {
    display: block;
    width: 200px;
    margin: auto;
    margin-bottom: 40px;
}

#features-list div span {
    font-size: 20px;
}

#features-list div h5 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #FFFFFFDD;
}

@media screen and (max-width: 720px) {
    #features-list {
        display: block;
    }

    #features-list div {
        display: block;
        margin: 30px 0px;
        width: 90%;
    }

    #features-list div img {
        margin: auto;
        width: 65%;
    }

    #top-what-is-punyshort-image {
        display: none;
    }
}
</style>
