/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "DSRC"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_EventFlags_H_
#define	_EventFlags_H_


#include "asn_application.h"

/* Including external dependencies */
#include "NativeInteger.h"

#ifdef __cplusplus
extern "C" {
#endif

/* EventFlags */
typedef long	 EventFlags_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_EventFlags;
asn_struct_free_f EventFlags_free;
asn_struct_print_f EventFlags_print;
asn_constr_check_f EventFlags_constraint;
ber_type_decoder_f EventFlags_decode_ber;
der_type_encoder_f EventFlags_encode_der;
xer_type_decoder_f EventFlags_decode_xer;
xer_type_encoder_f EventFlags_encode_xer;
per_type_decoder_f EventFlags_decode_uper;
per_type_encoder_f EventFlags_encode_uper;

#ifdef __cplusplus
}
#endif

#endif	/* _EventFlags_H_ */
#include "asn_internal.h"
