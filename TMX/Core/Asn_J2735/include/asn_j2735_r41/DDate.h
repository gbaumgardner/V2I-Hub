/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "DSRC"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_DDate_H_
#define	_DDate_H_


#include "asn_application.h"

/* Including external dependencies */
#include "DYear.h"
#include "DMonth.h"
#include "DDay.h"
#include "constr_SEQUENCE.h"

#ifdef __cplusplus
extern "C" {
#endif

/* DDate */
typedef struct DDate {
	DYear_t	 year;
	DMonth_t	 month;
	DDay_t	 day;
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} DDate_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_DDate;

#ifdef __cplusplus
}
#endif

#endif	/* _DDate_H_ */
#include "asn_internal.h"
