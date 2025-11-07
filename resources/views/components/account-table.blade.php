@props(['users'])

<style>
  .avatar-sm {
      width: 45px;
      height: 45px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ccc;
  }
</style>

<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead class="bg-success text-white">
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Kelas/Role</th>
        <th>Alamat</th>
        <th>Dibuat</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      @foreach($users as $i => $user)
        <tr>
          <td>{{ $i+1 }}</td>

          <!-- ✅ Foto Profil -->
          <td class="fw-semibold d-flex align-items-center gap-2">
  @php $avatar = $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.png'); @endphp
  <img src="{{ $avatar }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
  <span>{{ $user->name }}</span>
</td>


          <td class="fw-semibold">{{ $user->name }}</td>
          <td>{{ $user->email }}</td>

          <!-- ✅ Kelas untuk siswa -->
          <td>
            @if($user->role == 'siswa')
               <span class="badge bg-primary">
    {{ $user->class_assigned ?? '-' }}
  </span>
            @else
              <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
            @endif
          </td>

          <td>{{ $user->address ?? '-' }}</td>

          <td>{{ optional($user->created_at)->format('d M Y') }}</td>

          <td class="text-center">

            <!-- ✅ Tombol Edit (Modal Global) -->
            <button type="button"
    class="btn btn-sm btn-outline-primary rounded-pill edit-user-btn"
    data-id="{{ $user->id }}"
    data-name="{{ $user->name }}"
    data-email="{{ $user->email }}"
    data-role="{{ $user->role }}"
    data-birth_date="{{ $user->birth_date }}"
    data-address="{{ $user->address }}"
    data-parent="{{ $user->parent_id }}"
    data-classroom="{{ $user->classroom_id }}"
    data-photo="{{ $user->photo }}"
    data-bs-toggle="modal"
    data-bs-target="#editUserModal">
    <i class="bi bi-pencil"></i>
</button>


            <!-- Tombol hapus -->
            <form action="{{ route('admin.users.destroy', $user->id) }}"
                  method="POST"
                  class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger rounded-pill"
                      onclick="return confirm('Yakin hapus {{ $user->name }}?')">
                <i class="bi bi-trash"></i>
              </button>
            </form>

          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
