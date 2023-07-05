<template>
  <main class="table">
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Student_Name</th>
          <th>Total_Absence</th>
          <th>Date</th>
          <th>See More</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td> <img :src="require('@/assets/Zinzu Chan Lee.jpg')" alt="">Zinzu Chan Lee</td>
          <td>6</td>
          <td>17 Dec, 2022</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td><img :src="require('@/assets/Jeet Saru.jpg')" alt=""> Jeet Saru</td>
          <td>11</td>
          <td>27 Aug, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td><img :src="require('@/assets/Sonal Gharti.jpg')" alt=""> Sonal Gharti</td>
          <td>4</td>
          <td>14 Mar, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td><img :src="require('@/assets/Alson GC.jpg')" alt=""> Alson GC</td>
          <td>5</td>
          <td>25 May, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>5</td>
          <td><img :src="require('@/assets/Sarita Limbu.jpg')" alt="">Sarita Limbu</td>
          <td>0</td>
          <td>23 Apr, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>6</td>
          <td><img :src="require('@/assets/Alex Gonley.jpg')" alt=""> Alex Gonley</td>
          <td>10</td>
          <td>23 Apr, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>7</td>
          <td><img :src="require('@/assets/Jeet Saru.jpg')" alt=""> Jeet Saru</td>
          <td>6</td>
          <td>20 May, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>8</td>
          <td><img :src="require('@/assets/Sonal Gharti.jpg')" alt=""> Aayat Ali Khan</td>
          <td>5</td>
          <td>30 Feb, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
        <tr>
          <td>9</td>
          <td><img :src="require('@/assets/Alson GC.jpg')" alt=""> Alson GC</td>
          <td>2</td>
          <td>22 Dec, 2023</td>
          <td>
            <p class="status detail">Detail</p>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
export default {};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}
body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
main.table {
  margin: auto;
  width: 65vw;
  background-color: #fff5;
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}
table {
  width: 100%;
}

td img {
  width: 36px;
  height: 36px;
  margin-right: 0.5rem;
  border-radius: 50%;

  vertical-align: middle;
}

table,
th,
td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: left;
}

thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #d5d1defe;
  cursor: pointer;
  text-transform: capitalize;
}
tbody tr:nth-child(even) {
  background-color: #0000000b;
}
tbody tr:hover {
  background-color: #fff6 !important;
}

.status.detail {
  padding: 0.4rem 0;
  border-radius: 2rem;
  text-align: center;
  background-color: #50ded9;
  color: #006b21;
}

thead th:hover {
  color: #5cd2c6;
}
</style>