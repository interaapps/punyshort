<template>
  <div id="link-page">
    <div id="top-clicks-overview">
      <canvas id="clicks-chart" width="400" height="130"></canvas>
    </div>
    <div id="action-buttons" v-if="response.is_mine">
      <a class="button" @click="editMenuOpened = !editMenuOpened; if (editedLink === null) editedLink = response.link">edit</a>
      <a class="button" @click="deleteLink" id="delete-button">delete</a>
      <div id="edit-dropdown" v-if="editMenuOpened">
        <div class="title">
          <svg @click="editMenuOpened = false" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
          <span @click="edit">Edit</span>
        </div>
        <input v-model="editedLink" type="text" id="">
        <a class="button" @click="edit">edit</a>
      </div>
    </div>
    <table id="link-information">
      <tr>
        <td>Link</td>
        <td>{{response.link}}</td>
      </tr>
      <tr>
        <td>Shorten Link</td>
        <td>{{response.domain}}/{{response.url}}</td>
      </tr>
      <tr>
        <td>Total Clicks</td>
        <td>{{response.clicks}}</td>
      </tr>
      <tr>
        <td>Created</td>
        <td>{{response.created}}</td>
      </tr>
    </table>
    <div class="chart-category">
      <div class="chart-category-list">
        <h1>Countries</h1><br>

        <div v-for="(count, country) of response.countries" :key="country" class="list-entry">
          <img style="border-radius: 100%" :src="'https://cdn.interaapps.de/icon/flags/states/'+getISOCode(country)+'.svg'">
          <span class="list-entry-name">{{country}}</span>
          <span class="list-entry-right">{{count}}</span>
        </div>
      </div>
      <div class="chart-category-chart">
        <canvas id="country-chart" width="50px" height="50px"></canvas>
      </div>
    </div>
    <div class="chart-category">
      <div class="chart-category-chart">
        <canvas id="browser-chart" width="50px" height="50px"></canvas>
      </div>
      <div class="chart-category-list">
        <h1>Browsers</h1><br>
        <div v-for="(count, browser) of response.browser" :key="browser" class="list-entry">
          <img :src="'/assets/images/browser/'+getBrowser(browser)+'.svg'">
          <span class="list-entry-name">{{browser}}</span>
          <span class="list-entry-right">{{count}}</span>
        </div>
      </div>
    </div>
    <div class="chart-category">
      <div class="chart-category-list">
        <h1>Operating systems</h1><br>
        <div v-for="(count, os) of response.os" :key="os" class="list-entry">
          <img :src="'/assets/images/os/'+getOS(os)+'.svg'">
          <span class="list-entry-name">{{os}}</span>
          <span class="list-entry-right">{{count}}</span>
        </div>
      </div>
      <div class="chart-category-chart">
        <canvas id="os-chart" width="50px" height="50px"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js";
export default {
  name: 'Home',
  data(){
    return{
      id: this.$route.params.id,
      domain: "pnsh.ga",//window.location.host,
      response: {
        "id":"0",
        "link":"",
        "url":"-",
        "domain":"pnsh.ga",
        "created":"0000-0-0 00:00:00",
        "clicks":"0",
        "click":{},
        "browser":{},
        "os":{},
        "countries":{},
        "is_mine": false,
        "error":0
      },
      editedLink: null,
      editMenuOpened: false,
      iso3166List: require("../../assets/data/iso3166.json")
    }
  },
  components: {
  },
  mounted(){
    if (this.$route.query.domain)
      this.domain = this.$route.query.domain
    else
      this.domain = window.location.host
    this.load();
  },
  watch: {
    '$route'(){
      console.log(this.$route);
      this.id = this.$route.params.id
      if (this.$route.query.domain)
        this.domain = this.$route.query.domain
      else
        this.domain = window.location.host
      this.load();
    }
  },
  methods: {
    load(){
      this.punyshortClient
        .get("api/v2/getinformation/"+this.id, {domain: this.domain})
        .then(res=>res.json())
        .then(res=>{
          this.response = res
          console.log(res);
          this.createChart("clicks-chart", "", res.click, "line", {
            backgroundColor: "transparent",
            borderColor: "#FFFFFF"
          })
          this.createChart("country-chart", "Countries", res.countries, "pie", {}, {scales: {yAxes: [{ticks: {display: false}}]}})
          this.createChart("browser-chart", "Countries", res.browser, "pie", {}, {scales: {yAxes: [{ticks: {display: false}}]}})
          this.createChart("os-chart", "Countries", res.os, "pie", {}, {scales: {yAxes: [{ticks: {display: false}}]}})
        })
    },
    createChart(div, label, data, type="line", datasets = {}, options={}){
      var labels = [];
      var outData = [];

      for (const singleLabel in data) {
          labels.push(singleLabel);
          outData.push(data[singleLabel]);
      }

      var ctx = document.getElementById(div).getContext('2d');
      var myChart = new Chart(ctx, {
      type: type,
      options: {...{
          responsive: true,
          legend: {
              display: false
          },
          scales: {
              yAxes: [{
                  ticks: {
                    color: "#FFFFFF",
                    beginAtZero: true
                  }
              }]
          }
      }, ...options},
      data: {
          labels: labels,
          datasets: [{...({
              label: label,
              data: outData,
              backgroundColor: [
                  '#fb174066',
                  "#6603fc66",
                  "#22abf066",
                  "#f0225666",
                  "#e6db1c66",
                  "#f0632266",
                  "#22f03366",
                  "#e622f066",
                  "#f0222266"
              ],
              borderColor: [
                  '#fb1740',
                  "#6603fc",
                  "#22abf0",
                  "#f02256",
                  "#e6db1c",
                  "#f06322",
                  "#22f033",
                  "#e622f0",
                  "#f02222"
              ],
              borderWidth: 3
          }), ...datasets}]
      }
      });
    },
    edit(){
      this.punyshortClient.post("api/client/edit/"+this.response.id, {
        link: this.editedLink
      }).then(()=>{
        this.load()
        this.editMenuOpened = false
      })
    },
    getISOCode(name){
      for (const [code, countryName] of Object.entries(this.iso3166List)) {
        console.log(code, countryName)
        console.log(countryName.toLowerCase(), name.toLowerCase())
        if (countryName.toLowerCase() == name.toLowerCase()) {
          return  code;
          break;
        }
      }
      return "UKNWOWN";
    },
    getBrowser(name){
      if (name.toLowerCase() == 'chrome'   ||
          name.toLowerCase() == 'firefox'  ||
          name.toLowerCase() == 'safari'   ||
          name.toLowerCase() == 'opera'    ||
          name.toLowerCase() == 'netscape' ||
          name.toLowerCase() == 'maxthon' 
        ) {
          return name.toUpperCase()
      } else if (name == 'Internet Explorer') {
          return 'INTERNET-EXPLORER' 
      } else if (name == 'Handheld Browser') {
          return 'MOBILE' 
      }
      return "OTHER";
    },
    getOS(name){
      return name.toUpperCase().replaceAll(" ", "")
    },
    deleteLink(){
      this.punyshortClient.delete("api/client/delete/"+this.response.id).then(()=>{
        this.$router.push("/links")
        this.punyshortClient.get("user/links")
            .then(res=>{
                this.$store.state.links = res.json()
            })
      })
    }
  }
}
</script>
<style lang="scss" scoped>
@import '../../assets/scss/variables';

#top-clicks-overview {
  background: linear-gradient(180deg, #000459 0%, #00033E 100%);
}

#link-page {
  background: #141646;
  color: #FFF;

  .chart-category {
    padding: 40px;
    .chart-category-list {
      display: inline-block;
      width: calc(100% - 320px);
      margin-right: 10px;
      vertical-align: top;
      padding-left: 50px;
      padding-right: 50px;
    }
    .chart-category-chart {
      display: inline-block;
      height: 300px;
      width:  300px;
      vertical-align: top;
    }
  }

  #link-information {
    padding: 40px;
    tr {
      border: none;
      outline: none;
      td {
        border: none;
        outline: none;
        padding-right: 20px;
        max-width: 70vh;
        white-space: nowrap;
        overflow: auto;
      }
    }
  }

  #action-buttons {
    float: right;
    margin-top: 35px;
    margin-right: 15px;

    #delete-button {
      background: linear-gradient(268.27deg, #83000f 1.09%, #ab0014 100.73%);
    }
  }

  #edit-dropdown {
    background: #000230;
    position: absolute;
    border-radius: 8px;
    width: 300px;
    margin-left: -200px;
    margin-top: 10px;
    padding: 10px;
    min-height: 100px;

    .title {
      display: block;
      margin-bottom: 10px;

      svg {
        width:  32px;
        height: 32px;
        vertical-align: middle;
        padding: 2px;
        cursor: pointer;

        &:hover {
          background: #FFFFFF22;
          border-radius: 50%;
        }
      }
      span {
        vertical-align: middle;
        font-size: 17px;
        margin-left: 10px;
      }
    }

    input {
      outline: none;
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 4px;
      background: transparent;
      color: #FFFFFF;
      border: #FFFFFF44 2.5px solid;
    }

    .button {
      width: 100%;
      height: 40px;
      line-height: 18px;
    }
  }
}

.list-entry {
  padding: 10px;
  background: #FFFFFF11;
  border-radius: 4px;
  margin-bottom: 4px;
  margin-right: 1%;
  width: 49%;
  display: inline-block;

  img {
    width: 21px;
    height: 21px;
    vertical-align: middle;
    user-select: none;
    margin-right: 6px;
  }
  .list-entry-name {
    font-size: 19px;
    vertical-align: middle;
  }
  .list-entry-right {
    font-size: 19px;
    float: right;
    vertical-align: middle;
  }
}

@media screen and (max-width: 1100px) {
  
  .list-entry {
    width: 100%;
    display: block;
    margin-right: 0px;
  }

  #link-page {
    .chart-category {
      .chart-category-list {
        display: block;
        width: 100%;
        margin-right: 0px;
        padding-left: 10px;
        padding-right: 10px;
      }
      .chart-category-chart {
        display: block;
        height: 170px;
        width:  170px;
        margin-top: 40px;
        margin-bottom: 40px;
      }
    }
  }

}
</style>