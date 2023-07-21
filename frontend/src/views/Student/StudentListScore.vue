<template>
  <v-card>
    <v-tabs v-model="tab" bg-color="primary">
      <v-tab value="one">January</v-tab>
      <v-tab value="Two">February</v-tab>
      <v-tab value="three">March</v-tab>
      <v-tab value="four">April</v-tab>
      <v-tab value="five">May</v-tab>
      <v-tab value="six">June</v-tab>
      <v-tab value="seven">July</v-tab>
      <v-tab value="eight">August</v-tab>
      <v-tab value="night">September</v-tab>
      <v-tab value="ten">October</v-tab>
      <v-tab value="elevent">November</v-tab>
      <v-tab value="twelve">December</v-tab>
    </v-tabs>
    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="one">
          <v-table fixed-header height="300px">
            <thead>
              <tr>
                <th class="text-left">Khhmer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Physic</th>
                <th class="text-left">Chemistry</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Computer</th>
                <th class="text-left">Math</th>
                <th class="text-left">Total</th>
                <th class="text-left">Average</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr v-for="item in desserts" :key="item.name">
                <td>{{ item.name }}</td>
                <td>{{ item.calories }}</td>
              </tr> -->
            </tbody>
          </v-table>
        </v-window-item>

        <v-window-item value="two"> Two </v-window-item>

        <v-window-item value="three"> Three </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    tab: null,
  }),
};
</script>

<style>
</style>