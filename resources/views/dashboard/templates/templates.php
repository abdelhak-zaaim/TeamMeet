<script id="adminDashboardTemplate" type="text/x-jsrender">

<tr>
    <td>
        <div class="symbol symbol-45px me-2">
            <img src="{{:image}}" class="h-50 align-self-center" alt="">
        </div>
    </td>
    <td>
        <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{:name}}</a>
        <span class="text-muted fw-bold d-block">{{:email}}</span>
    </td>
    <td class="text-start">
        <span class="badge badge-light-success">{{:patientId}}</span>
    </td>
    <td class="text-start text-muted fw-bold">
        {{:registered}}
    </td>
</tr>



</script>
