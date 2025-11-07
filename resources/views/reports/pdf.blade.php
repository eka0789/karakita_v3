<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Karakter - {{ $student->name }}</title>
<style>
  body { font-family: DejaVu Sans, sans-serif; }
  .header {
      text-align: center;
      border-bottom: 3px solid #59AC77;
      margin-bottom: 20px;
      padding-bottom: 10px;
  }
  .logo {
      width: 80px;
      margin-bottom: 5px;
  }
  table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
  }
  table, th, td {
      border: 1px solid #ccc;
  }
  th {
      background-color: #59AC77;
      color: white;
      padding: 6px;
  }
  td {
      padding: 6px;
      font-size: 12px;
  }
  .footer {
      margin-top: 40px;
      text-align: right;
      font-size: 12px;
  }
</style>
</head>
<body>

<div class="header">
  <img src="{{ public_path('images/logo_RCK.png') }}" class="logo">
  <h2>KARAKTERKITA</h2>
  <strong>Rumah Cerdas KITA - Laporan Perkembangan Karakter Siswa</strong>
</div>

<p><strong>Nama Siswa:</strong> {{ $student->name }}</p>
<p><strong>Email:</strong> {{ $student->email }}</p>
<p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y') }}</p>

<h4 style="margin-top: 25px;">📊 Rekap Penilaian Karakter</h4>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nilai Perdamaian</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assessments as $assessment)
            @foreach($assessment->scores as $score)
            <tr>
                <td>{{ \Carbon\Carbon::parse($assessment->assessed_at)->format('d M Y') }}</td>
                <td>{{ $score->indicator->peaceValue->name ?? '-' }}</td>
                <td>{{ $score->score }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<div class="footer">
  <p>Rumah Cerdas KITA | Sistem Pembinaan Karakter Berbasis Teknologi</p>
</div>

</body>
</html>
