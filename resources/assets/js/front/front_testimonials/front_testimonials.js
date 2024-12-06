// delete front testimonial record code
listenClick('.front-testimonial-delete-btn', function () {
    let deleteFrontTestimonialId = $(this).attr('data-id')
    deleteItem(route('front-testimonials.destroy', deleteFrontTestimonialId),
        Lang.get('js.front_testimonial'))
})
