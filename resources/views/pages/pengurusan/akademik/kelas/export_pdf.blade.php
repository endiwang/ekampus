<style>
    html
    {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<html>
    <p>Maklumat Kelas dan Senarai Pelajar</p>
    
    <div class="row">
        <div class="col-lg-3">
            Nama Kelas
        </div>
        <div class="col-lg-9">
            {{ $datas['class_name'] ?? null }}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Bilangan Pelajar
        </div>
        <div class="col-lg-9">
            {{ $datas['max_student'] ?? null }}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            Status
        </div>
        <div class="col-lg-9">
            {{ $datas['status'] ?? null }}
        </div>
    </div>
</html>