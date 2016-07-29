/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "EU"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_EU_Reg_Position3D_H_
#define	_EU_Reg_Position3D_H_


#include "asn_application.h"

/* Including external dependencies */
#include "Altitude.h"
#include "constr_SEQUENCE.h"

#ifdef __cplusplus
extern "C" {
#endif

/* EU-Reg-Position3D */
typedef struct EU_Reg_Position3D {
	Altitude_t	 altitude;
	/*
	 * This type is extensible,
	 * possible extensions are below.
	 */
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} EU_Reg_Position3D_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_EU_Reg_Position3D;

#ifdef __cplusplus
}
#endif

#endif	/* _EU_Reg_Position3D_H_ */
#include "asn_internal.h"
