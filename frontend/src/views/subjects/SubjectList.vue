<template>
  <custom-title icon="mdi-cast-education"></custom-title>
  <v-container fluid class="pa-0">
    <v-row dense>
      <v-col v-for="card in cards" :key="card.title" :cols="card.flex">
        <v-card hover>
          <v-img
            :src="card.src"
            class="align-end"
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            height="200px"
            cover
          >
            <v-card-title class="text-white" v-text="card.title"></v-card-title>
          </v-img>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
              color="medium-emphasis"
              icon="mdi-heart"
              size="small"
            ></v-btn>

            <v-btn
              color="medium-emphasis"
              icon="mdi-bookmark"
              size="small"
            ></v-btn>

            <v-btn
              color="medium-emphasis"
              icon="mdi-share-variant"
              size="small"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
  export default {
    data: () => ({
      cards: [
        {
          title: 'Math',
          src: 'https://i0.wp.com/calmatters.org/wp-content/uploads/2021/08/math-curriculum.jpg?fit=2000%2C1500&ssl=1',
          flex: 4
        },
        {
          title: 'Byology',
          src: 'https://static.javatpoint.com/definition/images/biology-definition.png',
          flex: 4
        },
        {
          title: 'ICT',
          src: 'https://static.vecteezy.com/system/resources/previews/002/756/252/non_2x/ict-information-and-communication-technology-concept-on-virtual-screen-wireless-communication-network-intelligent-system-automation-robotic-hand-touching-digital-interface-vector.jpg',
          flex: 4
        },
        {
          title: 'History',
          src: 'https://www.eyeonasia.gov.sg/images/asean-countries/Cambodia%20snapshot%20cover.jpg',
          flex: 4
        },
        {
          title: 'Chemistry',
          src: 'https://images.theconversation.com/files/121885/original/image-20160510-20731-1pf8nwv.jpg?ixlib=rb-4.1.0&q=45&auto=format&w=926&fit=clip',
          flex: 4
        },
        {
          title: 'Khmer listeracture',
          src: 'https://vayofm.com/content_img/122270/582.jpg',
          flex: 4
        },
        {
          title: 'Geography',
          src: 'https://www.journeycambodia.com/userfiles/cambodia-geography.jpg',
          flex: 4
        },
        {
          title: 'Civics & Home Economics ',
          src: 'https://www.undp.org/sites/g/files/zskgke326/files/2024-05/undp-kh-civicengagement-banner_2.jpg',
          flex: 4
        },
        {
          title: 'Physical Education ',
          src: 'https://images.shiksha.com/mediadata/images/articles/1696940960phpBRPDBF.jpeg',
          flex: 4
        },
        {
          title: 'Physics',
          src: 'https://media.istockphoto.com/id/936903524/vector/blackboard-inscribed-with-scientific-formulas-and-calculations-in-physics-and-mathematics-can.jpg?s=612x612&w=0&k=20&c=sRLsJbHUVOYvZ_M16hti4fF9NM0RysfjAPUQrCJ8o4U=',
          flex: 4
        },
        {
          title: 'Earth Science',
          src: 'https://images.ctfassets.net/mrbo2ykgx5lt/23345/8a8a055c4c7a4a0f12da77cdda2be294/frontiers-in-earth-science-launch-solid-earth-geophysics.jpg?&w=1056&fm=jpg',
          flex: 4
        }
      ]
    })
  }
</script>
